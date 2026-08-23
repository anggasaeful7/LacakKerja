<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Enums\NotificationEvent;
use App\Enums\WorkOrderStatus;
use App\Models\ActivityLog;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\WorkOrder;
use App\Services\AuditLogger;
use App\Services\DomainNotifier;
use App\Services\InvoiceService;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    protected $signature = 'lacakkerja:send-reminders';

    protected $description = 'Kirim pengingat SLA overdue dan invoice jatuh tempo.';

    public function handle(DomainNotifier $notifier, AuditLogger $audit, InvoiceService $invoiceService): int
    {
        $sent = 0;

        Organization::query()->cursor()->each(function (Organization $organization) use ($notifier, $audit, $invoiceService, &$sent): void {
            $now = now($organization->timezone);
            $today = $now->toDateString();

            $workOrders = WorkOrder::query()
                ->forOrganization($organization)
                ->whereNotIn('status', [WorkOrderStatus::Completed->value, WorkOrderStatus::Cancelled->value])
                ->whereNotNull('sla_due_at')
                ->where('sla_due_at', '<', $now)
                ->with('primaryAssignment')
                ->get();

            foreach ($workOrders as $workOrder) {
                if ($this->alreadyLogged($organization, 'work_order.overdue', $workOrder, $today)) {
                    continue;
                }

                $managerPayload = [
                    'title' => 'Work order melewati SLA',
                    'body' => $workOrder->number.' · '.$workOrder->title,
                    'route' => route('work-orders.show', $workOrder),
                    'severity' => 'danger',
                    'subject_type' => $workOrder->getMorphClass(),
                    'subject_id' => $workOrder->id,
                ];
                $notifier->notifyManagers($organization, NotificationEvent::Overdue, $managerPayload);
                if ($workOrder->primaryAssignment !== null) {
                    $notifier->notifyTechnicians($organization, NotificationEvent::Overdue, [(int) $workOrder->primaryAssignment->user_id], [
                        ...$managerPayload,
                        'route' => route('technician.work-orders.show', $workOrder),
                    ]);
                }
                $audit->log('work_order.overdue', $workOrder, metadata: ['reminder_date' => $today]);
                $sent++;
            }

            $invoices = Invoice::query()
                ->forOrganization($organization)
                ->whereIn('status', [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value, InvoiceStatus::Overdue->value])
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<=', $today)
                ->get();

            foreach ($invoices as $invoice) {
                if ($invoice->status !== InvoiceStatus::Paid) {
                    $invoiceService->refreshStatus($invoice);
                    $invoice->refresh();
                }
                if ($this->alreadyLogged($organization, 'invoice.due', $invoice, $today)) {
                    continue;
                }

                $notifier->notifyManagers($organization, NotificationEvent::InvoiceDue, [
                    'title' => 'Invoice jatuh tempo',
                    'body' => $invoice->number.' · Rp '.number_format($invoice->amount_due, 0, ',', '.'),
                    'route' => route('invoices.show', $invoice),
                    'severity' => 'warning',
                    'subject_type' => $invoice->getMorphClass(),
                    'subject_id' => $invoice->id,
                ]);
                $audit->log('invoice.due', $invoice, metadata: ['reminder_date' => $today]);
                $sent++;
            }
        });

        $this->info("{$sent} reminder dikirim.");

        return self::SUCCESS;
    }

    private function alreadyLogged(Organization $organization, string $event, WorkOrder|Invoice $subject, string $date): bool
    {
        return ActivityLog::query()
            ->forOrganization($organization)
            ->where('event', $event)
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey())
            ->whereDate('created_at', $date)
            ->exists();
    }
}
