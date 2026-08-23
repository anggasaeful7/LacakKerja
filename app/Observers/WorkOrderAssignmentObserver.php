<?php

namespace App\Observers;

use App\Enums\NotificationEvent;
use App\Models\WorkOrderAssignment;
use App\Services\AuditLogger;
use App\Services\DomainNotifier;
use App\Services\OperationsDashboardCache;

class WorkOrderAssignmentObserver
{
    public function saved(WorkOrderAssignment $assignment): void
    {
        $organizationId = $assignment->workOrder()->value('organization_id');
        if ($organizationId !== null) {
            app(OperationsDashboardCache::class)->invalidate((int) $organizationId);
        }

        if (! $assignment->is_primary || (! $assignment->wasRecentlyCreated && ! $assignment->wasChanged(['user_id', 'is_primary']))) {
            return;
        }

        $workOrder = $assignment->workOrder()->with('customer')->first();
        $organization = $workOrder?->organization()->first();
        if ($workOrder === null || $organization === null) {
            return;
        }

        app(AuditLogger::class)->log('work_order.assigned', $assignment, changes: [
            'user_id' => [$assignment->getRawOriginal('user_id'), $assignment->user_id],
            'is_primary' => [$assignment->getRawOriginal('is_primary'), $assignment->is_primary],
        ]);
        app(DomainNotifier::class)->notifyTechnicians($organization, NotificationEvent::Assigned, [(int) $assignment->user_id], [
            'title' => 'Work order baru ditugaskan',
            'body' => $workOrder->number.' · '.$workOrder->title,
            'route' => route('technician.work-orders.show', $workOrder),
            'severity' => 'info',
            'subject_type' => $workOrder->getMorphClass(),
            'subject_id' => $workOrder->id,
        ]);
    }

    public function deleted(WorkOrderAssignment $assignment): void
    {
        $organizationId = $assignment->workOrder()->value('organization_id');
        if ($organizationId !== null) {
            app(OperationsDashboardCache::class)->invalidate((int) $organizationId);
            app(AuditLogger::class)->log('work_order.unassigned', $assignment, changes: [
                'user_id' => [$assignment->user_id, null],
            ], organizationId: (int) $organizationId);
        }
    }
}
