<?php

namespace App\Http\Controllers;

use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\TechnicianProfile;
use App\Models\User;
use App\Models\WorkOrder;
use App\Services\CurrentOrganization;
use App\Services\DispatchAgenda;
use App\Services\ScheduleConflictDetector;
use App\Services\WorkOrderService;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DispatchController extends Controller
{
    public function __construct(
        private readonly DispatchAgenda $dispatchAgenda,
        private readonly ScheduleConflictDetector $conflictDetector,
        private readonly WorkOrderService $workOrderService,
    ) {}

    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeManager($request->user(), $organization);

        $selectedDate = $this->parseDate($request->input('date'), $organization);
        $view = in_array($request->string('view')->toString(), ['day', 'week'], true) ? $request->string('view')->toString() : 'day';
        $from = $view === 'week' ? $selectedDate->startOfWeek(CarbonImmutable::MONDAY) : $selectedDate->startOfDay();
        $to = $from->addDays($view === 'week' ? 7 : 1);
        $filters = [
            'technician_id' => $request->integer('technician_id') ?: null,
            'status' => WorkOrderStatus::tryFrom($request->string('status')->toString())?->value,
            'priority' => WorkOrderPriority::tryFrom($request->string('priority')->toString())?->value,
            'area' => trim($request->string('area')->toString()),
            'q' => trim($request->string('q')->toString()),
        ];

        $workOrders = $this->dispatchAgenda->forRange($organization, $from, $to, $filters);
        $technicians = Membership::query()
            ->forOrganization($organization)
            ->where('status', MembershipStatus::Active)
            ->where('role', OrganizationRole::Technician)
            ->with('user.technicianProfile')
            ->get()
            ->sortBy('user.name')
            ->values();

        foreach ($technicians as $membership) {
            if ($membership->user->technicianProfile === null) {
                $membership->user->setRelation('technicianProfile', TechnicianProfile::firstOrCreate(
                    ['organization_id' => $organization->id, 'user_id' => $membership->user_id],
                    ['display_color' => '#0284c7', 'availability' => $this->defaultAvailability()],
                ));
            }
        }

        $lanes = $workOrders->groupBy(fn (WorkOrder $workOrder): string => (string) data_get($workOrder->primaryAssignment, 'user_id', 'unassigned'));
        $weekDays = collect(range(0, $view === 'week' ? 6 : 0))->map(fn (int $offset): CarbonImmutable => $from->addDays($offset));

        return view('pages.dispatch.index', [
            'organization' => $organization,
            'selectedDate' => $selectedDate,
            'from' => $from,
            'to' => $to,
            'view' => $view,
            'filters' => $filters,
            'workOrders' => $workOrders,
            'lanes' => $lanes,
            'technicians' => $technicians,
            'weekDays' => $weekDays,
            'summary' => [
                'total' => $workOrders->count(),
                'unassigned' => $lanes->get('unassigned', collect())->count(),
                'conflicts' => $workOrders->sum(fn (WorkOrder $workOrder): int => (int) $workOrder->getAttribute('schedule_conflict_count')),
            ],
        ]);
    }

    public function schedule(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeManager($request->user(), $organization);
        Gate::forUser($request->user())->authorize('update', $workOrder);
        abort_unless($workOrder->organization_id === $organization->id, 404);

        $validated = $request->validate([
            'technician_id' => ['nullable', 'integer'],
            'scheduled_start' => ['nullable', 'date'],
            'scheduled_end' => ['nullable', 'date', 'after:scheduled_start'],
            'confirmed' => ['accepted'],
        ]);

        $hasStart = filled($validated['scheduled_start'] ?? null);
        $hasEnd = filled($validated['scheduled_end'] ?? null);
        $hasTechnician = filled($validated['technician_id'] ?? null);
        if (($hasStart xor $hasEnd) || ($hasTechnician && (! $hasStart || ! $hasEnd))) {
            throw ValidationException::withMessages(['scheduled_start' => 'Tanggal, jam mulai, dan jam selesai harus diisi bersama teknisi.']);
        }

        $technician = null;
        if ($hasTechnician) {
            $technician = Membership::query()
                ->forOrganization($organization)
                ->where('user_id', (int) $validated['technician_id'])
                ->where('status', MembershipStatus::Active)
                ->where('role', OrganizationRole::Technician)
                ->with('user')
                ->first();
            if ($technician === null) {
                throw ValidationException::withMessages(['technician_id' => 'Teknisi tidak terdaftar aktif pada organisasi ini.']);
            }
        }

        $start = $hasStart ? CarbonImmutable::parse((string) $validated['scheduled_start'], $organization->timezone) : null;
        $end = $hasEnd ? CarbonImmutable::parse((string) $validated['scheduled_end'], $organization->timezone) : null;
        $conflicts = $technician !== null && $start !== null && $end !== null
            ? $this->conflictDetector->for($organization, $technician->user_id, $start, $end, $workOrder->id)
            : collect();

        DB::transaction(function () use ($workOrder, $technician, $start, $end, $request): void {
            $workOrder->update([
                'scheduled_start' => $start,
                'scheduled_end' => $end,
            ]);
            $workOrder->assignments()->update(['is_primary' => false]);
            if ($technician !== null) {
                $workOrder->assignments()->updateOrCreate(
                    ['user_id' => $technician->user_id],
                    ['is_primary' => true, 'assigned_at' => now()],
                );
            }

            if ($workOrder->status === WorkOrderStatus::Draft && $technician !== null && $start !== null && $end !== null) {
                $this->workOrderService->transition($workOrder->fresh()->load('primaryAssignment'), WorkOrderStatus::Scheduled, $request->user());
            }
        });

        $message = 'Jadwal dan assignment berhasil disimpan setelah konfirmasi server.';
        if ($conflicts->isNotEmpty()) {
            $message .= ' Perhatian: jadwal bertabrakan dengan '.$conflicts->count().' work order lain.';
        }

        return redirect()->route('dispatch.index', $this->returnQuery($request))->with('status', $message);
    }

    public function editTechnician(Request $request, User $user): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeManager($request->user(), $organization);
        $membership = $this->technicianMembership($organization, $user);
        abort_unless($membership !== null, 404);

        $profile = TechnicianProfile::firstOrCreate(
            ['organization_id' => $organization->id, 'user_id' => $user->id],
            ['display_color' => '#0284c7', 'availability' => $this->defaultAvailability()],
        );

        return view('pages.dispatch.technician-profile', [
            'organization' => $organization,
            'user' => $user,
            'profile' => $profile,
            'returnQuery' => $this->returnQuery($request),
        ]);
    }

    public function updateTechnician(Request $request, User $user): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeManager($request->user(), $organization);
        $membership = $this->technicianMembership($organization, $user);
        abort_unless($membership !== null, 404);
        $profile = TechnicianProfile::firstOrCreate(['organization_id' => $organization->id, 'user_id' => $user->id]);

        $validated = $request->validate([
            'employee_code' => ['nullable', 'string', 'max:64', Rule::unique('technician_profiles', 'employee_code')->where(fn ($query) => $query->where('organization_id', $organization->id))->ignore($profile->id)],
            'phone' => ['nullable', 'string', 'max:40'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'display_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'availability' => ['array'],
            'availability.*.start' => ['nullable', 'date_format:H:i'],
            'availability.*.end' => ['nullable', 'date_format:H:i'],
        ]);

        $availability = [];
        foreach ((array) ($validated['availability'] ?? []) as $day => $slot) {
            if (filled($slot['start'] ?? null) && filled($slot['end'] ?? null)) {
                $availability[$day] = ['start' => $slot['start'], 'end' => $slot['end']];
            }
        }

        $profile->update([
            'employee_code' => $validated['employee_code'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'skills' => collect(explode(',', (string) ($validated['skills'] ?? '')))->map(fn (string $skill): string => trim($skill))->filter()->values()->all(),
            'display_color' => $validated['display_color'],
            'availability' => $availability,
        ]);

        return redirect()->route('dispatch.index', $this->returnQuery($request))->with('status', 'Profil teknisi diperbarui.');
    }

    private function authorizeManager(User $user, Organization $organization): void
    {
        abort_unless($user->membershipFor($organization)?->role->canManageMasterData() ?? false, 403);
        Gate::forUser($user)->authorize('viewAny', [WorkOrder::class, $organization]);
    }

    private function technicianMembership(Organization $organization, User $user): ?Membership
    {
        return Membership::query()->forOrganization($organization)->where('user_id', $user->id)->where('role', OrganizationRole::Technician)->where('status', MembershipStatus::Active)->first();
    }

    private function parseDate(mixed $value, Organization $organization): CarbonImmutable
    {
        if (! filled($value)) {
            return CarbonImmutable::now($organization->timezone)->startOfDay();
        }

        try {
            return CarbonImmutable::parse((string) $value, $organization->timezone)->startOfDay();
        } catch (\Throwable) {
            return CarbonImmutable::now($organization->timezone)->startOfDay();
        }
    }

    /** @return array<string, string|int> */
    private function returnQuery(Request $request): array
    {
        return collect(['date', 'view', 'technician_id', 'status', 'priority', 'area', 'q'])
            ->mapWithKeys(fn (string $key): array => [$key => $request->input('return_'.$key, $request->input($key))])
            ->filter(fn (mixed $value): bool => filled($value))
            ->all();
    }

    /** @return array<string, array{start: string, end: string}> */
    private function defaultAvailability(): array
    {
        return collect(['mon', 'tue', 'wed', 'thu', 'fri'])->mapWithKeys(fn (string $day): array => [$day => ['start' => '08:00', 'end' => '17:00']])->all();
    }
}
