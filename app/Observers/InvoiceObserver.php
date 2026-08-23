<?php

namespace App\Observers;

use App\Enums\InvoiceStatus;
use App\Enums\NotificationEvent;
use App\Models\Invoice;
use App\Models\Organization;
use App\Services\AuditLogger;
use App\Services\DomainNotifier;
use App\Services\OperationsDashboardCache;

class InvoiceObserver
{
    public function saved(Invoice $invoice): void
    {
        app(OperationsDashboardCache::class)->invalidate($invoice->organization_id);
    }

    public function updated(Invoice $invoice): void
    {
        if (! $invoice->wasChanged('status')) {
            return;
        }

        $organization = Organization::query()->find($invoice->organization_id);
        if ($organization === null) {
            return;
        }

        $from = (string) $invoice->getRawOriginal('status');
        $to = $invoice->status->value;
        $audit = app(AuditLogger::class);
        $audit->log('invoice.status_changed', $invoice, changes: [
            'status' => [$from, $to],
            'amount_due' => [$invoice->getRawOriginal('amount_due'), $invoice->amount_due],
        ]);

        $auditEvent = match ($invoice->status) {
            InvoiceStatus::Issued => 'invoice.issued',
            InvoiceStatus::Overdue => 'invoice.due',
            InvoiceStatus::Paid => 'invoice.paid',
            InvoiceStatus::Void => 'invoice.void',
            default => null,
        };
        if ($auditEvent !== null) {
            $audit->log($auditEvent, $invoice, metadata: ['status' => $to]);
        }

        $notificationEvent = match ($invoice->status) {
            InvoiceStatus::Issued => NotificationEvent::InvoiceIssued,
            InvoiceStatus::Overdue => NotificationEvent::InvoiceDue,
            InvoiceStatus::Paid => NotificationEvent::InvoicePaid,
            default => null,
        };
        if ($notificationEvent === null) {
            return;
        }

        app(DomainNotifier::class)->notifyManagers($organization, $notificationEvent, [
            'title' => match ($notificationEvent) {
                NotificationEvent::InvoicePaid => 'Pembayaran invoice diterima',
                NotificationEvent::InvoiceDue => 'Invoice jatuh tempo',
                default => 'Invoice diterbitkan',
            },
            'body' => $invoice->number.' · Rp '.number_format($invoice->total_amount, 0, ',', '.'),
            'route' => route('invoices.show', $invoice),
            'severity' => match ($notificationEvent) {
                NotificationEvent::InvoicePaid => 'success',
                NotificationEvent::InvoiceDue => 'warning',
                default => 'info',
            },
            'subject_type' => $invoice->getMorphClass(),
            'subject_id' => $invoice->id,
        ]);
    }

    public function deleted(Invoice $invoice): void
    {
        app(OperationsDashboardCache::class)->invalidate($invoice->organization_id);
    }
}
