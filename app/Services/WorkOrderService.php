<?php

namespace App\Services;

use App\Enums\AttachmentUploadStatus;
use App\Enums\ChecklistStatus;
use App\Enums\WorkOrderStatus;
use App\Models\ChecklistTemplate;
use App\Models\Organization;
use App\Models\TimeLog;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WorkOrderService
{
    public function __construct(
        private readonly WorkOrderNumberGenerator $numberGenerator,
    ) {}

    public function createNumber(Organization $organization): string
    {
        return $this->numberGenerator->next($organization);
    }

    public function snapshotChecklist(WorkOrder $workOrder): void
    {
        if ($workOrder->checklistItems()->exists() || $workOrder->service_id === null) {
            return;
        }

        $template = ChecklistTemplate::query()
            ->forOrganization($workOrder->organization_id)
            ->where('service_id', $workOrder->service_id)
            ->where('status', ChecklistStatus::Published)
            ->where('is_current', true)
            ->with('items')
            ->orderByDesc('version')
            ->first();

        if ($template === null) {
            return;
        }

        $workOrder->checklistItems()->createMany(
            $template->items->map(fn ($item): array => [
                'sort_order' => $item->position,
                'label' => $item->label,
                'input_type' => $item->input_type->value,
                'is_required' => $item->is_required,
                'photo_required' => $item->photo_required,
                'options' => $item->options ?? [],
            ])->all(),
        );
    }

    public function transition(WorkOrder $workOrder, WorkOrderStatus $to, User $actor, ?string $reason = null): WorkOrder
    {
        return DB::transaction(function () use ($workOrder, $to, $actor, $reason): WorkOrder {
            $locked = WorkOrder::query()->whereKey($workOrder->getKey())->lockForUpdate()->firstOrFail();
            $from = $locked->status;

            if (! in_array($to, $from->allowedTransitions(), true)) {
                throw ValidationException::withMessages([
                    'status' => "Transisi {$from->label()} ke {$to->label()} tidak diizinkan.",
                ]);
            }

            $reasonRequired = $to === WorkOrderStatus::OnHold
                || $to === WorkOrderStatus::Cancelled
                || ($from === WorkOrderStatus::Completed && $to === WorkOrderStatus::InProgress);

            if ($reasonRequired && blank($reason)) {
                throw ValidationException::withMessages([
                    'reason' => 'Alasan wajib diisi untuk perubahan status ini.',
                ]);
            }

            if ($to === WorkOrderStatus::Scheduled && (! $locked->scheduleIsValid() || ! $locked->hasPrimaryTechnician())) {
                throw ValidationException::withMessages([
                    'status' => 'Work order harus memiliki jadwal valid dan teknisi utama sebelum dijadwalkan.',
                ]);
            }

            $this->applyTransition($locked, $from, $to, $actor, $reason);

            return $locked->fresh();
        });
    }

    public function complete(WorkOrder $workOrder, User $actor): WorkOrder
    {
        return DB::transaction(function () use ($workOrder, $actor): WorkOrder {
            $locked = WorkOrder::query()
                ->whereKey($workOrder->getKey())
                ->with(['checklistItems', 'notes', 'timeLogs', 'attachments', 'signature', 'organization'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status !== WorkOrderStatus::InProgress) {
                throw ValidationException::withMessages([
                    'status' => 'Work order hanya dapat diselesaikan saat sedang dikerjakan.',
                ]);
            }

            $issues = $this->completionIssues($locked);
            if ($issues !== []) {
                throw ValidationException::withMessages(['completion' => $issues]);
            }

            $this->applyTransition($locked, WorkOrderStatus::InProgress, WorkOrderStatus::Completed, $actor);

            return $locked->fresh();
        });
    }

    /** @return array<int, string> */
    public function completionIssues(WorkOrder $workOrder): array
    {
        $issues = [];
        $missingChecklist = $workOrder->checklistItems
            ->filter(fn ($item): bool => $item->is_required && ! $item->isComplete())
            ->pluck('label')
            ->values()
            ->all();

        if ($missingChecklist !== []) {
            $issues[] = 'Checklist wajib belum lengkap: '.implode(', ', $missingChecklist).'.';
        }

        if (! $workOrder->notes->contains(fn ($note): bool => filled(trim($note->body)))) {
            $issues[] = 'Tambahkan minimal satu catatan penyelesaian.';
        }

        if ($workOrder->timeLogs->contains(fn (TimeLog $log): bool => $log->isActive())) {
            $issues[] = 'Hentikan time log yang masih aktif.';
        }

        if ($workOrder->attachments->contains(fn ($attachment): bool => $attachment->is_required && $attachment->upload_status !== AttachmentUploadStatus::Completed)) {
            $issues[] = 'Upload wajib masih menunggu atau gagal.';
        }

        if ($workOrder->checklistItems->contains(fn ($item): bool => $item->photo_required)
            && ! $workOrder->attachments->contains(fn ($attachment): bool => $attachment->upload_status === AttachmentUploadStatus::Completed)) {
            $issues[] = 'Tambahkan minimal satu foto bukti untuk checklist wajib foto.';
        }

        if (data_get($workOrder->organization->settings, 'signature_required', false) && $workOrder->signature === null) {
            $issues[] = 'Tanda tangan pelanggan wajib tersedia.';
        }

        return $issues;
    }

    public function startTimeLog(WorkOrder $workOrder, User $user): TimeLog
    {
        if ($workOrder->status !== WorkOrderStatus::InProgress) {
            throw ValidationException::withMessages(['time' => 'Time log hanya dapat dimulai saat pekerjaan sedang dikerjakan.']);
        }

        if ($workOrder->timeLogs()->where('user_id', $user->id)->whereNull('ended_at')->exists()) {
            throw ValidationException::withMessages(['time' => 'Kamu sudah memiliki time log aktif pada work order ini.']);
        }

        if (TimeLog::query()->where('user_id', $user->id)->whereNull('ended_at')->exists()) {
            throw ValidationException::withMessages(['time' => 'Selesaikan time log aktif lain sebelum memulai pekerjaan ini.']);
        }

        return $workOrder->timeLogs()->create([
            'user_id' => $user->id,
            'started_at' => now(),
        ]);
    }

    public function stopTimeLog(TimeLog $timeLog, User $user): TimeLog
    {
        if ($timeLog->ended_at !== null) {
            return $timeLog;
        }

        $endedAt = now();
        $timeLog->update([
            'ended_at' => $endedAt,
            'duration_minutes' => max(1, $timeLog->started_at->diffInMinutes($endedAt)),
        ]);

        return $timeLog->fresh();
    }

    private function applyTransition(WorkOrder $workOrder, WorkOrderStatus $from, WorkOrderStatus $to, User $actor, ?string $reason = null): void
    {
        $workOrder->forceFill([
            'status' => $to,
            'completed_at' => $to === WorkOrderStatus::Completed ? now() : null,
            'lock_version' => $workOrder->lock_version + 1,
        ])->save();

        $workOrder->statusHistories()->create([
            'changed_by' => $actor->id,
            'from_status' => $from,
            'to_status' => $to,
            'reason' => $reason,
            'created_at' => now(),
        ]);
    }
}
