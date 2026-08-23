<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\AuditLogger;
use App\Services\OperationsDashboardCache;

class PaymentObserver
{
    public function saved(Payment $payment): void
    {
        app(OperationsDashboardCache::class)->invalidate($payment->organization_id);

        if (! $payment->wasRecentlyCreated) {
            return;
        }

        app(AuditLogger::class)->log('invoice.payment_recorded', $payment, changes: [
            'invoice_id' => $payment->invoice_id,
            'amount' => $payment->amount,
            'method' => $payment->method->value,
            'reference' => $payment->reference,
            'notes' => $payment->notes,
        ]);
    }

    public function deleted(Payment $payment): void
    {
        app(OperationsDashboardCache::class)->invalidate($payment->organization_id);
        app(AuditLogger::class)->log('invoice.payment_deleted', $payment, changes: [
            'amount' => $payment->amount,
            'method' => $payment->method->value,
        ]);
    }
}
