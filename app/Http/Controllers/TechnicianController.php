<?php

namespace App\Http\Controllers;

use App\Enums\AttachmentCategory;
use App\Enums\ChecklistInputType;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderNoteVisibility;
use App\Enums\WorkOrderStatus;
use App\Models\Attachment;
use App\Models\Organization;
use App\Models\TimeLog;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderChecklistItem;
use App\Services\AttachmentQuota;
use App\Services\CurrentOrganization;
use App\Services\TechnicianSyncService;
use App\Services\WorkOrderService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TechnicianController extends Controller
{
    public function __construct(
        private readonly WorkOrderService $workOrderService,
        private readonly TechnicianSyncService $technicianSyncService,
    ) {}

    public function today(Request $request): View
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $today = CarbonImmutable::now($organization->timezone)->startOfDay();
        $tomorrow = $today->addDay();

        $todayTasks = $this->assignedQuery($organization, $request->user())
            ->where(function (Builder $query) use ($today, $tomorrow): void {
                $query->where(function (Builder $scheduled) use ($today, $tomorrow): void {
                    $scheduled->whereNotNull('scheduled_start')
                        ->whereNotNull('scheduled_end')
                        ->where('scheduled_start', '<', $tomorrow)
                        ->where('scheduled_end', '>', $today);
                })->orWhereIn('status', [
                    WorkOrderStatus::Dispatched->value,
                    WorkOrderStatus::EnRoute->value,
                    WorkOrderStatus::InProgress->value,
                    WorkOrderStatus::OnHold->value,
                ]);
            })
            ->orderByRaw("CASE status WHEN 'in_progress' THEN 1 WHEN 'en_route' THEN 2 WHEN 'dispatched' THEN 3 ELSE 4 END")
            ->orderBy('scheduled_start')
            ->get();

        $upcomingTasks = $this->assignedQuery($organization, $request->user())
            ->where('scheduled_start', '>=', $tomorrow)
            ->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value])
            ->orderBy('scheduled_start')
            ->limit(5)
            ->get();

        $activeStatuses = [WorkOrderStatus::Dispatched, WorkOrderStatus::EnRoute, WorkOrderStatus::InProgress, WorkOrderStatus::OnHold];
        $nextTask = $todayTasks->first(fn (WorkOrder $workOrder): bool => in_array($workOrder->status, $activeStatuses, true))
            ?? $todayTasks->first(fn (WorkOrder $workOrder): bool => ! $workOrder->status->isTerminal());

        return view('pages.technician.today', [
            'organization' => $organization,
            'today' => $today,
            'todayTasks' => $todayTasks,
            'upcomingTasks' => $upcomingTasks,
            'nextTask' => $nextTask,
            'summary' => [
                'total' => $todayTasks->count(),
                'active' => $todayTasks->whereIn('status', $activeStatuses)->count(),
                'completed' => $todayTasks->where('status', WorkOrderStatus::Completed)->count(),
            ],
        ]);
    }

    public function tasks(Request $request): View
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $tab = in_array($request->string('tab')->toString(), ['upcoming', 'active', 'history'], true)
            ? $request->string('tab')->toString()
            : 'upcoming';
        $query = $this->assignedQuery($organization, $request->user());

        if ($tab === 'active') {
            $query->whereIn('status', [WorkOrderStatus::Dispatched->value, WorkOrderStatus::EnRoute->value, WorkOrderStatus::InProgress->value, WorkOrderStatus::OnHold->value]);
        } elseif ($tab === 'history') {
            $query->whereIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value]);
        } else {
            $query->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value]);
        }

        $workOrders = $query
            ->orderByRaw('CASE WHEN scheduled_start IS NULL THEN 1 ELSE 0 END')
            ->orderBy('scheduled_start')
            ->paginate(12)
            ->withQueryString();

        return view('pages.technician.tasks', compact('organization', 'tab', 'workOrders'));
    }

    public function syncCenter(Request $request): View
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);

        return view('pages.technician.sync', compact('organization'));
    }

    public function syncBootstrap(Request $request): JsonResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $query = $this->assignedQuery($organization, $request->user())
            ->with(['checklistItems', 'notes.author'])
            ->whereNotIn('status', [WorkOrderStatus::Cancelled->value]);
        $workOrderId = $request->integer('work_order_id');

        if ($workOrderId > 0) {
            $query->whereKey($workOrderId);
        } else {
            $today = CarbonImmutable::now($organization->timezone)->startOfDay();
            $tomorrow = $today->addDay();
            $query->where(function (Builder $builder) use ($today, $tomorrow): void {
                $builder->where(function (Builder $scheduled) use ($today, $tomorrow): void {
                    $scheduled->whereNotNull('scheduled_start')
                        ->whereNotNull('scheduled_end')
                        ->where('scheduled_start', '<', $tomorrow)
                        ->where('scheduled_end', '>', $today);
                })->orWhereIn('status', [
                    WorkOrderStatus::Dispatched->value,
                    WorkOrderStatus::EnRoute->value,
                    WorkOrderStatus::InProgress->value,
                    WorkOrderStatus::OnHold->value,
                ]);
            })->orderBy('scheduled_start')->limit(25);
        }

        $workOrders = $query->get()
            ->map(fn (WorkOrder $workOrder): array => $this->technicianSyncService->workOrderPayload($workOrder))
            ->values()
            ->all();

        return response()->json([
            'scope' => [
                'organization_id' => $organization->id,
                'user_id' => $request->user()->id,
            ],
            'generated_at' => now()->toIso8601String(),
            'work_orders' => $workOrders,
        ]);
    }

    public function syncBatch(Request $request): JsonResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $validated = $request->validate([
            'operations' => ['required', 'array', 'max:'.TechnicianSyncService::MAX_BATCH_SIZE],
            'operations.*.client_operation_id' => ['required', 'uuid'],
            'operations.*.type' => ['required', Rule::in(['checklist.update', 'note.create'])],
            'operations.*.work_order_id' => ['required', 'integer', 'min:1'],
            'operations.*.base_version' => ['required', 'integer', 'min:1'],
            'operations.*.payload' => ['required', 'array'],
        ]);

        return response()->json($this->technicianSyncService->synchronize($organization, $request->user(), $validated['operations']));
    }

    public function show(Request $request, WorkOrder $workOrder): View
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'view');
        $workOrder->load([
            'organization',
            'customer',
            'site',
            'asset',
            'service',
            'primaryAssignment.user',
            'checklistItems.completer',
            'notes.author',
            'attachments.uploader',
            'timeLogs.user',
            'materialUsages.user',
            'signature',
        ]);

        $activeTimeLog = $workOrder->timeLogs->first(fn (TimeLog $timeLog): bool => $timeLog->isActive() && $timeLog->user_id === $request->user()->id);
        $primaryAction = $this->primaryAction($workOrder);
        $completionIssues = $this->workOrderService->completionIssues($workOrder);

        return view('pages.technician.show', [
            'organization' => $organization,
            'workOrder' => $workOrder,
            'activeTimeLog' => $activeTimeLog,
            'primaryAction' => $primaryAction,
            'completionIssues' => $completionIssues,
            'mapUrl' => $this->mapUrl($workOrder),
            'canComplete' => $completionIssues === [],
        ]);
    }

    public function transition(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'transition');
        $validated = $request->validate([
            'status' => ['required', Rule::enum(WorkOrderStatus::class)],
            'reason' => ['nullable', 'string', 'max:2000'],
        ]);
        $target = WorkOrderStatus::from($validated['status']);

        if ($target === WorkOrderStatus::Completed) {
            $this->workOrderService->complete($workOrder, $request->user());

            return redirect()->route('technician.work-orders.success', $workOrder);
        }

        $this->workOrderService->transition($workOrder, $target, $request->user(), $validated['reason'] ?? null);

        return back()->with('status', 'Status pekerjaan diperbarui di server.');
    }

    public function updateChecklist(Request $request, WorkOrder $workOrder, WorkOrderChecklistItem $item): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'updateChecklist');
        abort_unless($workOrder->organization_id === $organization->id && $item->work_order_id === $workOrder->id, 404);
        $inputType = $item->input_type;
        $rules = match ($inputType) {
            ChecklistInputType::Checkbox => ['value' => ['nullable', 'boolean']],
            ChecklistInputType::Number => ['value' => ['nullable', 'numeric', 'max:999999999']],
            ChecklistInputType::Choice => ['value' => ['nullable', 'string', Rule::in($item->options ?? [])]],
            ChecklistInputType::Text => ['value' => ['nullable', 'string', 'max:5000']],
        };
        $validated = $request->validate($rules);
        $rawValue = $validated['value'] ?? null;
        $value = match ($inputType) {
            ChecklistInputType::Checkbox => $request->boolean('value') ? true : null,
            default => filled($rawValue) ? $rawValue : null,
        };
        $item->update([
            'value' => $value === null ? null : ['value' => $value],
            'completed_by' => $value === null ? null : $request->user()->id,
            'completed_at' => $value === null ? null : now(),
        ]);
        $workOrder->increment('lock_version');

        return back()->with('status', 'Checklist tersimpan.');
    }

    public function startTime(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'trackTime');
        $this->workOrderService->startTimeLog($workOrder->load('timeLogs'), $request->user());

        return back()->with('status', 'Timer dimulai setelah konfirmasi server.');
    }

    public function stopTime(Request $request, WorkOrder $workOrder, TimeLog $timeLog): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'trackTime');
        abort_unless($workOrder->organization_id === $organization->id && $timeLog->work_order_id === $workOrder->id && $timeLog->user_id === $request->user()->id, 404);
        $this->workOrderService->stopTimeLog($timeLog, $request->user());

        return back()->with('status', 'Timer dihentikan dan durasi tersimpan.');
    }

    public function addNote(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'addNote');
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:10000'],
            'visibility' => ['required', Rule::enum(WorkOrderNoteVisibility::class)],
        ]);
        $workOrder->notes()->create([
            'user_id' => $request->user()->id,
            'visibility' => $validated['visibility'],
            'body' => $validated['body'],
        ]);
        $workOrder->increment('lock_version');

        return back()->with('status', 'Catatan tersimpan.');
    }

    public function uploadPhoto(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'attach');
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp', 'extensions:jpg,jpeg,png,webp'],
            'category' => ['required', Rule::enum(AttachmentCategory::class)],
            'is_required' => ['nullable', 'boolean'],
            'client_upload_id' => ['nullable', 'uuid'],
        ]);
        $clientUploadId = $validated['client_upload_id'] ?? null;
        if ($clientUploadId !== null && $workOrder->attachments()->where('client_upload_id', $clientUploadId)->exists()) {
            return back()->with('status', 'Foto ini sudah tersimpan di server.');
        }
        $file = $request->file('file');
        if (! $file instanceof UploadedFile) {
            throw ValidationException::withMessages(['file' => 'File foto tidak valid.']);
        }
        $this->storeAttachment($organization, $workOrder, $request->user(), $file, AttachmentCategory::from($validated['category']), (bool) ($validated['is_required'] ?? false), $clientUploadId);

        return back()->with('status', 'Foto berhasil diunggah.');
    }

    public function downloadAttachment(Request $request, WorkOrder $workOrder, Attachment $attachment): Response|StreamedResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'view');
        abort_unless($attachment->work_order_id === $workOrder->id, 404);
        $disk = Storage::disk($attachment->disk);
        abort_unless($disk->exists($attachment->path), 404);

        return $disk->download($attachment->path, $attachment->original_name, ['Content-Type' => $attachment->mime_type]);
    }

    public function addMaterial(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'addNote');
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:180'],
            'quantity' => ['required', 'numeric', 'gt:0', 'max:999999'],
            'unit' => ['required', 'string', 'max:32'],
            'unit_price' => ['nullable', 'integer', 'min:0', 'max:9223372036854775807'],
        ]);
        $quantity = (float) $validated['quantity'];
        $unitPrice = (int) ($validated['unit_price'] ?? 0);
        $workOrder->materialUsages()->create([
            'user_id' => $request->user()->id,
            'description' => $validated['description'],
            'quantity' => $quantity,
            'unit' => $validated['unit'],
            'unit_price' => $unitPrice,
            'total' => (int) round($quantity * $unitPrice),
        ]);

        return back()->with('status', 'Material usage tersimpan.');
    }

    public function storeSignature(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'addNote');
        if ($workOrder->status !== WorkOrderStatus::InProgress) {
            throw ValidationException::withMessages(['signature' => 'Tanda tangan hanya dapat disimpan saat pekerjaan sedang dikerjakan.']);
        }
        $validated = $request->validate([
            'signer_name' => ['required', 'string', 'max:160'],
            'signature_data' => ['required', 'string', 'max:3000000'],
            'consent' => ['accepted'],
        ]);
        if (! str_starts_with($validated['signature_data'], 'data:image/png;base64,')) {
            throw ValidationException::withMessages(['signature_data' => 'Format tanda tangan tidak valid.']);
        }
        $binary = base64_decode(str_replace('data:image/png;base64,', '', $validated['signature_data']), true);
        if ($binary === false || strlen($binary) > 2000000) {
            throw ValidationException::withMessages(['signature_data' => 'Tanda tangan terlalu besar atau rusak.']);
        }
        $existing = $workOrder->signature;
        $path = 'work-orders/'.$workOrder->id.'/signature/'.Str::uuid()->toString().'.png';
        Storage::disk('local')->put($path, $binary);
        $workOrder->signature()->updateOrCreate([], [
            'signer_name' => $validated['signer_name'],
            'path' => $path,
            'consent_version' => 'm6-v1',
            'signed_at' => now(),
        ]);
        if ($existing !== null && $existing->path !== $path) {
            Storage::disk('local')->delete($existing->path);
        }

        return back()->with('status', 'Tanda tangan tersimpan secara privat.');
    }

    public function complete(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'complete');
        $this->workOrderService->complete($workOrder, $request->user());

        return redirect()->route('technician.work-orders.success', $workOrder);
    }

    public function success(Request $request, WorkOrder $workOrder): View
    {
        $organization = $this->organization($request);
        $this->authorizeTechnician($request->user(), $organization);
        $this->authorizeWorkOrder($request, $workOrder, 'view');
        $nextTask = $this->assignedQuery($organization, $request->user())
            ->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value])
            ->whereNotNull('scheduled_start')
            ->where('scheduled_start', '>', now())
            ->orderBy('scheduled_start')
            ->first();

        return view('pages.technician.success', compact('organization', 'workOrder', 'nextTask'));
    }

    private function organization(Request $request): Organization
    {
        return app(CurrentOrganization::class)->require($request->user());
    }

    private function authorizeTechnician(User $user, Organization $organization): void
    {
        $membership = $user->membershipFor($organization);
        abort_unless($membership !== null && $membership->role === OrganizationRole::Technician && $membership->status === MembershipStatus::Active, 403);
    }

    private function authorizeWorkOrder(Request $request, WorkOrder $workOrder, string $ability): void
    {
        Gate::forUser($request->user())->authorize($ability, $workOrder);
    }

    /** @return Builder<WorkOrder> */
    private function assignedQuery(Organization $organization, User $user): Builder
    {
        return WorkOrder::query()
            ->forOrganization($organization)
            ->whereHas('assignments', fn (Builder $assignment): Builder => $assignment->where('user_id', $user->id))
            ->with(['customer', 'site', 'service', 'primaryAssignment.user']);
    }

    /** @return array{target: WorkOrderStatus, label: string, icon: string}|null */
    private function primaryAction(WorkOrder $workOrder): ?array
    {
        return match ($workOrder->status) {
            WorkOrderStatus::Scheduled, WorkOrderStatus::Dispatched => ['target' => $workOrder->status === WorkOrderStatus::Scheduled ? WorkOrderStatus::Dispatched : WorkOrderStatus::EnRoute, 'label' => 'Berangkat', 'icon' => 'paper-airplane'],
            WorkOrderStatus::EnRoute => ['target' => WorkOrderStatus::InProgress, 'label' => 'Mulai kerja', 'icon' => 'play'],
            WorkOrderStatus::OnHold => ['target' => WorkOrderStatus::InProgress, 'label' => 'Lanjutkan', 'icon' => 'play'],
            WorkOrderStatus::InProgress => ['target' => WorkOrderStatus::Completed, 'label' => 'Selesaikan', 'icon' => 'check-circle'],
            default => null,
        };
    }

    private function mapUrl(WorkOrder $workOrder): string
    {
        $site = $workOrder->site;
        $query = $site->latitude !== null && $site->longitude !== null
            ? $site->latitude.','.$site->longitude
            : trim(implode(', ', array_filter([$site->address_line1, $site->city, $site->province])));

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode($query);
    }

    private function storeAttachment(Organization $organization, WorkOrder $workOrder, User $user, UploadedFile $file, AttachmentCategory $category, bool $isRequired, ?string $clientUploadId = null): Attachment
    {
        app(AttachmentQuota::class)->ensureAvailable($organization, (int) $file->getSize());
        $extension = strtolower((string) $file->getClientOriginalExtension());
        $filename = Str::uuid()->toString().($extension !== '' ? '.'.$extension : '');
        $path = Storage::disk('local')->putFileAs('work-orders/'.$workOrder->id, $file, $filename);
        if ($path === false) {
            throw ValidationException::withMessages(['file' => 'Foto gagal disimpan.']);
        }

        return $workOrder->attachments()->create([
            'client_upload_id' => $clientUploadId,
            'uploaded_by' => $user->id,
            'category' => $category,
            'disk' => 'local',
            'path' => $path,
            'original_name' => Str::limit($file->getClientOriginalName(), 255, ''),
            'mime_type' => (string) $file->getMimeType(),
            'size_bytes' => (int) $file->getSize(),
            'checksum' => hash_file('sha256', $file->getRealPath()),
            'upload_status' => 'completed',
            'is_required' => $isRequired,
        ]);
    }
}
