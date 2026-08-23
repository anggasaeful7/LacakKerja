<?php

namespace App\Observers;

use App\Enums\NotificationEvent;
use App\Enums\WorkOrderStatus;
use App\Models\Organization;
use App\Models\WorkOrder;
use App\Services\AuditLogger;
use App\Services\DomainNotifier;
use App\Services\OperationsDashboardCache;

class WorkOrderObserver
{
    public function saved(WorkOrder $workOrder): void
    {
        app(OperationsDashboardCache::class)->invalidate($workOrder->organization_id);
    }

    public function updated(WorkOrder $workOrder): void
    {
        $organization = Organization::query()->find($workOrder->organization_id);
        if ($organization === null) {
            return;
        }

        $notifier = app(DomainNotifier::class);
        $audit = app(AuditLogger::class);
        $technicianIds = $workOrder->assignments()
            ->where('is_primary', true)
            ->pluck('user_id')
            ->map(fn (int|string $id): int => (int) $id)
            ->all();
        $subject = [
            'subject_type' => $workOrder->getMorphClass(),
            'subject_id' => $workOrder->id,
        ];

        if ($workOrder->wasChanged(['scheduled_start', 'scheduled_end'])) {
            $audit->log('work_order.rescheduled', $workOrder, changes: [
                'scheduled_start' => [$workOrder->getRawOriginal('scheduled_start'), $workOrder->getChanges()['scheduled_start'] ?? null],
                'scheduled_end' => [$workOrder->getRawOriginal('scheduled_end'), $workOrder->getChanges()['scheduled_end'] ?? null],
            ]);
            $notifier->notifyTechnicians($organization, NotificationEvent::Rescheduled, $technicianIds, [
                ...$subject,
                'title' => 'Jadwal work order berubah',
                'body' => $workOrder->number.' dijadwalkan ulang menjadi '.($workOrder->scheduled_start?->format('d M Y H:i') ?? 'tanpa jadwal').'.',
                'route' => route('technician.work-orders.show', $workOrder),
                'severity' => 'info',
            ]);
        }

        if (! $workOrder->wasChanged('status')) {
            return;
        }

        $from = (string) $workOrder->getRawOriginal('status');
        $to = $workOrder->status->value;
        $audit->log('work_order.status_changed', $workOrder, changes: [
            'status' => [$from, $to],
            'completed_at' => [$workOrder->getRawOriginal('completed_at'), $workOrder->getChanges()['completed_at'] ?? $workOrder->getRawOriginal('completed_at')],
        ]);

        if ($from === WorkOrderStatus::Completed->value && $workOrder->status === WorkOrderStatus::InProgress) {
            $audit->log('work_order.reopened', $workOrder, metadata: ['status' => $to]);
        }

        $event = match ($workOrder->status) {
            WorkOrderStatus::Completed => NotificationEvent::Completed,
            WorkOrderStatus::Cancelled => NotificationEvent::Cancelled,
            default => null,
        };
        if ($event === null) {
            return;
        }

        $audit->log($event->value, $workOrder, metadata: ['status' => $to]);
        $notifier->notifyTechnicians($organization, $event, $technicianIds, [
            ...$subject,
            'title' => $event === NotificationEvent::Completed ? 'Work order selesai' : 'Work order dibatalkan',
            'body' => $workOrder->number.' · '.$workOrder->title,
            'route' => route('technician.work-orders.show', $workOrder),
            'severity' => $event === NotificationEvent::Cancelled ? 'danger' : 'success',
        ]);
    }

    public function deleted(WorkOrder $workOrder): void
    {
        app(OperationsDashboardCache::class)->invalidate($workOrder->organization_id);
    }
}
