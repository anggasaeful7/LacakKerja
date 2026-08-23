<?php

namespace App\Http\Controllers;

use App\Enums\AttachmentCategory;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderNoteVisibility;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Asset;
use App\Models\Attachment;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\TimeLog;
use App\Models\WorkOrder;
use App\Models\WorkOrderChecklistItem;
use App\Services\AttachmentQuota;
use App\Services\CurrentOrganization;
use App\Services\WorkOrderService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WorkOrderController extends Controller
{
    public function __construct(
        private readonly WorkOrderService $workOrderService,
    ) {}

    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [WorkOrder::class, $organization]);

        $search = trim((string) $request->string('q'));
        $query = WorkOrder::query()
            ->forOrganization($organization)
            ->with(['customer', 'site', 'service', 'primaryAssignment.user'])
            ->withCount(['checklistItems', 'notes']);

        if ($search !== '') {
            $query->search($search);
        }

        if ($request->filled('status') && WorkOrderStatus::tryFrom((string) $request->string('status')) !== null) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('priority') && WorkOrderPriority::tryFrom((string) $request->string('priority')) !== null) {
            $query->where('priority', $request->string('priority')->toString());
        }

        if ($request->filled('date')) {
            $query->whereDate('scheduled_start', $request->date('date'));
        }

        if ($request->string('scope')->toString() === 'active') {
            $query->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value]);
        }

        if ($request->string('assignment')->toString() === 'unassigned') {
            $query->whereDoesntHave('assignments', fn (Builder $assignment): Builder => $assignment->where('is_primary', true));
        }

        if ($request->string('sla')->toString() === 'overdue') {
            $query->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value])
                ->whereNotNull('sla_due_at')
                ->where('sla_due_at', '<', now());
        } elseif ($request->string('sla')->toString() === 'risk') {
            $query->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value])
                ->whereNotNull('sla_due_at')
                ->where('sla_due_at', '<=', now()->addHours(4));
        }

        $workOrders = $query
            ->orderByRaw("CASE priority WHEN 'urgent' THEN 1 WHEN 'high' THEN 2 WHEN 'normal' THEN 3 ELSE 4 END")
            ->orderByRaw("CASE WHEN sla_due_at IS NOT NULL AND sla_due_at < CURRENT_TIMESTAMP AND status NOT IN ('completed', 'cancelled') THEN 0 ELSE 1 END")
            ->orderByDesc('scheduled_start')
            ->paginate(15)
            ->withQueryString();

        return view('pages.work-orders.index', [
            'workOrders' => $workOrders,
            'organization' => $organization,
            'search' => $search,
        ]);
    }

    public function create(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [WorkOrder::class, $organization]);

        return view('pages.work-orders.form', [
            'workOrder' => new WorkOrder(['priority' => WorkOrderPriority::Normal]),
            'organization' => $organization,
            ...$this->formData($organization),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [WorkOrder::class, $organization]);
        $validated = $this->validated($request, $organization);
        $this->validateRelationships($validated, $organization);

        $workOrder = DB::transaction(function () use ($validated, $organization, $request): WorkOrder {
            $number = $this->workOrderService->createNumber($organization);
            $scheduled = filled($validated['scheduled_start'] ?? null)
                && filled($validated['scheduled_end'] ?? null)
                && filled($validated['technician_id'] ?? null);
            $status = $scheduled ? WorkOrderStatus::Scheduled : WorkOrderStatus::Draft;

            $workOrder = $organization->workOrders()->create([
                'customer_id' => $validated['customer_id'],
                'customer_site_id' => $validated['customer_site_id'],
                'asset_id' => $validated['asset_id'] ?? null,
                'service_id' => $validated['service_id'] ?? null,
                'created_by' => $request->user()->id,
                'number' => $number,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'priority' => $validated['priority'],
                'status' => $status,
                'scheduled_start' => $this->dateValue($validated['scheduled_start'] ?? null, $organization),
                'scheduled_end' => $this->dateValue($validated['scheduled_end'] ?? null, $organization),
                'sla_due_at' => $this->dateValue($validated['sla_due_at'] ?? null, $organization),
                'estimated_total' => $validated['estimated_total'] ?? 0,
                'lock_version' => 1,
            ]);

            if (filled($validated['technician_id'] ?? null)) {
                $this->syncAssignment($workOrder, (int) $validated['technician_id']);
            }

            $this->workOrderService->snapshotChecklist($workOrder);
            $workOrder->statusHistories()->create([
                'changed_by' => $request->user()->id,
                'from_status' => null,
                'to_status' => $status,
                'reason' => 'Work order dibuat.',
                'created_at' => now(),
            ]);

            return $workOrder;
        });

        return redirect()->route('work-orders.show', $workOrder)->with('status', 'Work order berhasil dibuat.');
    }

    public function edit(Request $request, WorkOrder $workOrder): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $workOrder->load('primaryAssignment');

        return view('pages.work-orders.form', [
            'workOrder' => $workOrder,
            'organization' => $organization,
            ...$this->formData($organization),
        ]);
    }

    public function update(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);
        $validated = $this->validated($request, $organization);
        $this->validateRelationships($validated, $organization);

        if ($workOrder->checklistItems()->exists() && (int) ($validated['service_id'] ?? 0) !== (int) $workOrder->service_id) {
            throw ValidationException::withMessages([
                'service_id' => 'Service tidak dapat diganti setelah checklist snapshot dibuat.',
            ]);
        }

        $shouldBeScheduled = filled($validated['scheduled_start'] ?? null)
            && filled($validated['scheduled_end'] ?? null)
            && filled($validated['technician_id'] ?? null);

        if ($workOrder->status === WorkOrderStatus::Scheduled && ! $shouldBeScheduled) {
            throw ValidationException::withMessages([
                'scheduled_start' => 'Work order terjadwal harus tetap memiliki jadwal dan teknisi.',
            ]);
        }

        DB::transaction(function () use ($workOrder, $validated, $organization): void {
            $workOrder->update([
                'customer_id' => $validated['customer_id'],
                'customer_site_id' => $validated['customer_site_id'],
                'asset_id' => $validated['asset_id'] ?? null,
                'service_id' => $validated['service_id'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'priority' => $validated['priority'],
                'scheduled_start' => $this->dateValue($validated['scheduled_start'] ?? null, $organization),
                'scheduled_end' => $this->dateValue($validated['scheduled_end'] ?? null, $organization),
                'sla_due_at' => $this->dateValue($validated['sla_due_at'] ?? null, $organization),
                'estimated_total' => $validated['estimated_total'] ?? 0,
            ]);
            $this->syncAssignment($workOrder, filled($validated['technician_id'] ?? null) ? (int) $validated['technician_id'] : null);
            $this->workOrderService->snapshotChecklist($workOrder->fresh());
        });

        if ($workOrder->status === WorkOrderStatus::Draft && $shouldBeScheduled) {
            $this->workOrderService->transition($workOrder->fresh(), WorkOrderStatus::Scheduled, $request->user());
        }

        return redirect()->route('work-orders.show', $workOrder)->with('status', 'Work order berhasil diperbarui.');
    }

    public function show(Request $request, WorkOrder $workOrder): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $workOrder->load([
            'customer',
            'site',
            'asset',
            'service',
            'creator',
            'primaryAssignment.user',
            'assignments.user',
            'statusHistories.actor',
            'checklistItems.completer',
            'notes.author',
            'attachments.uploader',
            'timeLogs.user',
            'materialUsages.user',
            'signature',
            'invoices',
        ]);

        $canManage = $request->user()->membershipFor($organization)?->role->canManageMasterData() ?? false;
        $canTransition = Gate::forUser($request->user())->check('transition', $workOrder);

        return view('pages.work-orders.show', [
            'workOrder' => $workOrder,
            'organization' => $organization,
            'canManage' => $canManage,
            'canTransition' => $canTransition,
            'completionIssues' => $this->workOrderService->completionIssues($workOrder),
        ]);
    }

    public function transition(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('transition', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $validated = $request->validate([
            'status' => ['required', Rule::enum(WorkOrderStatus::class)],
            'reason' => ['nullable', 'string', 'max:2000'],
        ]);
        $target = WorkOrderStatus::from($validated['status']);

        if ($target === WorkOrderStatus::Completed) {
            $this->workOrderService->complete($workOrder, $request->user());
        } else {
            $this->workOrderService->transition($workOrder, $target, $request->user(), $validated['reason'] ?? null);
        }

        return back()->with('status', 'Status work order diperbarui.');
    }

    public function complete(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('complete', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $this->workOrderService->complete($workOrder, $request->user());

        return back()->with('status', 'Work order ditandai selesai.');
    }

    public function addNote(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('addNote', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:10000'],
            'visibility' => ['required', Rule::enum(WorkOrderNoteVisibility::class)],
        ]);

        $workOrder->notes()->create([
            'user_id' => $request->user()->id,
            'visibility' => $validated['visibility'],
            'body' => $validated['body'],
        ]);

        return back()->with('status', 'Catatan berhasil ditambahkan.');
    }

    public function updateChecklist(Request $request, WorkOrder $workOrder, WorkOrderChecklistItem $item): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('updateChecklist', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id && $item->work_order_id === $workOrder->id, 404);

        $request->validate([
            'value' => ['nullable'],
        ]);
        $value = $request->has('value') ? ['value' => $request->input('value')] : null;

        $item->update([
            'value' => $value,
            'completed_by' => $value === null ? null : $request->user()->id,
            'completed_at' => $value === null ? null : now(),
        ]);

        return back()->with('status', 'Checklist diperbarui.');
    }

    public function startTime(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('trackTime', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $this->workOrderService->startTimeLog($workOrder->load('timeLogs'), $request->user());

        return back()->with('status', 'Time log dimulai.');
    }

    public function stopTime(Request $request, WorkOrder $workOrder, TimeLog $timeLog): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('trackTime', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id && $timeLog->work_order_id === $workOrder->id, 404);

        if ($timeLog->user_id !== $request->user()->id && ! $request->user()->membershipFor($organization)?->role->canManageMasterData()) {
            abort(403);
        }

        $this->workOrderService->stopTimeLog($timeLog, $request->user());

        return back()->with('status', 'Time log dihentikan.');
    }

    public function uploadAttachment(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('attach', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp,pdf', 'mimetypes:image/jpeg,image/png,image/webp,application/pdf', 'extensions:jpg,jpeg,png,webp,pdf'],
            'category' => ['required', Rule::enum(AttachmentCategory::class)],
            'is_required' => ['nullable', 'boolean'],
        ]);

        $file = $request->file('file');
        app(AttachmentQuota::class)->ensureAvailable($organization, (int) $file->getSize());
        $extension = strtolower((string) $file->getClientOriginalExtension());
        $filename = Str::uuid()->toString().($extension !== '' ? '.'.$extension : '');
        $directory = 'work-orders/'.$workOrder->id;
        $path = Storage::disk('local')->putFileAs($directory, $file, $filename);

        if ($path === false) {
            throw ValidationException::withMessages(['file' => 'File gagal disimpan.']);
        }

        $workOrder->attachments()->create([
            'uploaded_by' => $request->user()->id,
            'category' => $validated['category'],
            'disk' => 'local',
            'path' => $path,
            'original_name' => Str::limit($file->getClientOriginalName(), 255, ''),
            'mime_type' => (string) $file->getMimeType(),
            'size_bytes' => (int) $file->getSize(),
            'checksum' => hash_file('sha256', $file->getRealPath()),
            'upload_status' => 'completed',
            'is_required' => (bool) ($validated['is_required'] ?? false),
        ]);

        return back()->with('status', 'Attachment berhasil diunggah.');
    }

    public function downloadAttachment(Request $request, WorkOrder $workOrder, Attachment $attachment): Response|StreamedResponse
    {
        Gate::forUser($request->user())->authorize('download', $attachment);
        abort_unless($attachment->work_order_id === $workOrder->id, 404);

        $disk = Storage::disk($attachment->disk);
        abort_unless($disk->exists($attachment->path), 404);

        return $disk->download($attachment->path, $attachment->original_name, [
            'Content-Type' => $attachment->mime_type,
        ]);
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, Organization $organization): array
    {
        return $request->validate([
            'customer_id' => ['required', 'integer', Rule::exists('customers', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'customer_site_id' => ['required', 'integer', Rule::exists('customer_sites', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'asset_id' => ['nullable', 'integer', Rule::exists('assets', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'technician_id' => ['nullable', 'integer', Rule::exists('memberships', 'user_id')->where(fn ($query) => $query->where('organization_id', $organization->id)->where('role', OrganizationRole::Technician->value)->where('status', MembershipStatus::Active->value))],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:10000'],
            'priority' => ['required', Rule::enum(WorkOrderPriority::class)],
            'scheduled_start' => ['nullable', 'date'],
            'scheduled_end' => ['nullable', 'date', 'after:scheduled_start'],
            'sla_due_at' => ['nullable', 'date'],
            'estimated_total' => ['nullable', 'integer', 'min:0', 'max:9223372036854775807'],
        ]);
    }

    /** @param array<string, mixed> $validated */
    private function validateRelationships(array $validated, Organization $organization): void
    {
        $site = CustomerSite::query()->forOrganization($organization)->whereKey($validated['customer_site_id'])->firstOrFail();
        if ((int) $site->customer_id !== (int) $validated['customer_id']) {
            throw ValidationException::withMessages(['customer_site_id' => 'Site tidak termasuk pelanggan yang dipilih.']);
        }

        if (filled($validated['asset_id'] ?? null)) {
            $asset = Asset::query()->forOrganization($organization)->whereKey($validated['asset_id'])->firstOrFail();
            if ((int) $asset->customer_id !== (int) $validated['customer_id'] || (int) $asset->customer_site_id !== (int) $validated['customer_site_id']) {
                throw ValidationException::withMessages(['asset_id' => 'Aset harus berasal dari customer dan site yang dipilih.']);
            }
        }
    }

    /** @return array<string, mixed> */
    private function formData(Organization $organization): array
    {
        return [
            'customers' => Customer::query()->forOrganization($organization)->with('sites')->orderBy('name')->get(),
            'assets' => Asset::query()->forOrganization($organization)->with(['customer', 'site'])->orderBy('name')->get(),
            'services' => Service::query()->forOrganization($organization)->where('is_active', true)->orderBy('name')->get(),
            'technicians' => Membership::query()->forOrganization($organization)->where('status', MembershipStatus::Active)->where('role', OrganizationRole::Technician)->with('user')->get()->sortBy('user.name')->values(),
        ];
    }

    private function syncAssignment(WorkOrder $workOrder, ?int $technicianId): void
    {
        $workOrder->assignments()->update(['is_primary' => false]);

        if ($technicianId === null) {
            return;
        }

        $workOrder->assignments()->updateOrCreate(
            ['user_id' => $technicianId],
            ['is_primary' => true, 'assigned_at' => now()],
        );
    }

    private function dateValue(?string $value, Organization $organization): ?CarbonImmutable
    {
        return filled($value) ? CarbonImmutable::parse($value, $organization->timezone) : null;
    }
}
