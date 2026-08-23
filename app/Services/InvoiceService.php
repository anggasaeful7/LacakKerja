<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\WorkOrderStatus;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceService
{
    public function __construct(
        private readonly InvoiceNumberGenerator $numberGenerator,
        private readonly InvoiceCalculator $calculator,
    ) {}

    /** @param array<string, mixed> $data */
    public function createDraft(Organization $organization, User $actor, array $data): Invoice
    {
        return DB::transaction(function () use ($organization, $data): Invoice {
            $items = is_array($data['items'] ?? null) ? $data['items'] : [];
            $calculated = $this->calculator->calculate(
                $items,
                (int) ($data['discount_amount'] ?? 0),
                (string) ($data['tax_rate'] ?? '0'),
            );
            $workOrder = $this->lockedWorkOrder($organization, $data['work_order_id'] ?? null);
            $customerId = (int) ($data['customer_id'] ?? 0);
            if ($customerId < 1 && $workOrder !== null) {
                $customerId = $workOrder->customer_id;
            }

            if ($customerId < 1) {
                throw ValidationException::withMessages(['customer_id' => 'Pelanggan wajib dipilih.']);
            }

            if ($workOrder !== null) {
                if ($workOrder->status !== WorkOrderStatus::Completed) {
                    throw ValidationException::withMessages(['work_order_id' => 'Invoice hanya dapat dibuat dari work order selesai.']);
                }

                if ($workOrder->customer_id !== $customerId) {
                    throw ValidationException::withMessages(['customer_id' => 'Pelanggan invoice harus sama dengan work order.']);
                }

                if ($workOrder->invoices()->whereNot('status', InvoiceStatus::Void)->exists()) {
                    throw ValidationException::withMessages(['work_order_id' => 'Work order ini sudah memiliki invoice aktif.']);
                }
            }

            $invoice = $organization->invoices()->create([
                'customer_id' => $customerId,
                'work_order_id' => $workOrder?->id,
                'number' => $this->numberGenerator->next($organization),
                'status' => InvoiceStatus::Draft,
                'currency' => $organization->currency,
                'due_date' => $data['due_date'] ?? null,
                'subtotal' => $calculated['subtotal'],
                'discount_amount' => $calculated['discount_amount'],
                'tax_rate' => $calculated['tax_rate'],
                'tax_amount' => $calculated['tax_amount'],
                'total_amount' => $calculated['total_amount'],
                'paid_amount' => 0,
                'amount_due' => $calculated['total_amount'],
                'notes' => filled($data['notes'] ?? null) ? $data['notes'] : null,
            ]);
            $invoice->items()->createMany($calculated['items']);

            return $invoice->fresh(['customer', 'workOrder', 'items']);
        });
    }

    /** @param array<string, mixed> $data */
    public function updateDraft(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data): Invoice {
            $locked = Invoice::query()->whereKey($invoice->id)->lockForUpdate()->firstOrFail();
            $this->ensureEditable($locked);
            $items = is_array($data['items'] ?? null) ? $data['items'] : [];
            $calculated = $this->calculator->calculate(
                $items,
                (int) ($data['discount_amount'] ?? 0),
                (string) ($data['tax_rate'] ?? '0'),
            );

            if (filled($data['customer_id'] ?? null) && (int) $data['customer_id'] !== $locked->customer_id) {
                throw ValidationException::withMessages(['customer_id' => 'Pelanggan invoice tidak dapat diganti setelah draft dibuat.']);
            }

            $locked->update([
                'due_date' => $data['due_date'] ?? null,
                'discount_amount' => $calculated['discount_amount'],
                'tax_rate' => $calculated['tax_rate'],
                'tax_amount' => $calculated['tax_amount'],
                'subtotal' => $calculated['subtotal'],
                'total_amount' => $calculated['total_amount'],
                'paid_amount' => 0,
                'amount_due' => $calculated['total_amount'],
                'notes' => filled($data['notes'] ?? null) ? $data['notes'] : null,
            ]);
            $locked->items()->delete();
            $locked->items()->createMany($calculated['items']);

            return $locked->fresh(['customer', 'workOrder', 'items']);
        });
    }

    public function issue(Invoice $invoice): Invoice
    {
        return DB::transaction(function () use ($invoice): Invoice {
            $locked = Invoice::query()->whereKey($invoice->id)->with('items')->lockForUpdate()->firstOrFail();
            $this->ensureEditable($locked);

            if ($locked->items->isEmpty() || $locked->total_amount < 1) {
                throw ValidationException::withMessages(['invoice' => 'Invoice harus memiliki item dan total lebih besar dari 0.']);
            }

            $locked->update([
                'status' => InvoiceStatus::Issued,
                'issued_at' => now(),
                'amount_due' => $locked->total_amount,
            ]);

            return $locked->fresh(['customer', 'workOrder', 'items', 'payments']);
        });
    }

    public function void(Invoice $invoice, string $reason): Invoice
    {
        return DB::transaction(function () use ($invoice, $reason): Invoice {
            $locked = Invoice::query()->whereKey($invoice->id)->lockForUpdate()->firstOrFail();
            if ($locked->status === InvoiceStatus::Void) {
                return $locked;
            }

            if ($locked->status === InvoiceStatus::Paid || $locked->paid_amount > 0) {
                throw ValidationException::withMessages(['invoice' => 'Invoice dengan pembayaran tidak dapat dibatalkan. Buat revisi melalui proses koreksi resmi.']);
            }

            if (blank(trim($reason))) {
                throw ValidationException::withMessages(['reason' => 'Alasan pembatalan wajib diisi.']);
            }

            $locked->update([
                'status' => InvoiceStatus::Void,
                'voided_at' => now(),
                'void_reason' => $reason,
                'amount_due' => 0,
            ]);

            return $locked->fresh(['customer', 'workOrder', 'items', 'payments']);
        });
    }

    public function revise(Invoice $invoice, User $actor): Invoice
    {
        return DB::transaction(function () use ($invoice, $actor): Invoice {
            $locked = Invoice::query()->with('items')->whereKey($invoice->id)->lockForUpdate()->firstOrFail();
            if ($locked->status === InvoiceStatus::Draft || $locked->status === InvoiceStatus::Void) {
                throw ValidationException::withMessages(['invoice' => 'Hanya invoice terbit yang dapat direvisi.']);
            }

            if ($locked->paid_amount > 0 || $locked->payments()->exists()) {
                throw ValidationException::withMessages(['invoice' => 'Invoice dengan pembayaran tidak dapat direvisi otomatis.']);
            }

            $sourceWorkOrderId = $locked->work_order_id;
            if ($sourceWorkOrderId !== null) {
                $locked->update(['status' => InvoiceStatus::Void, 'voided_at' => now(), 'void_reason' => 'Revisi sedang dibuat.', 'amount_due' => 0]);
            }

            $newInvoice = $this->createDraft($locked->organization, $actor, [
                'customer_id' => $locked->customer_id,
                'work_order_id' => $sourceWorkOrderId,
                'due_date' => $locked->due_date?->toDateString(),
                'discount_amount' => $locked->discount_amount,
                'tax_rate' => $locked->tax_rate,
                'notes' => $locked->notes,
                'items' => $locked->items->map(fn ($item): array => [
                    'service_id' => $item->service_id,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ])->all(),
            ]);

            $newInvoice->update(['revision_of_id' => $locked->id]);
            $locked->update([
                'status' => InvoiceStatus::Void,
                'voided_at' => now(),
                'void_reason' => 'Direvisi menjadi '.$newInvoice->number.'.',
                'amount_due' => 0,
            ]);

            return $newInvoice->fresh(['customer', 'workOrder', 'items']);
        });
    }

    /** @param array<string, mixed> $data */
    public function recordPayment(Invoice $invoice, User $receiver, array $data): Payment
    {
        return DB::transaction(function () use ($invoice, $receiver, $data): Payment {
            $locked = Invoice::query()->whereKey($invoice->id)->lockForUpdate()->firstOrFail();
            $this->refreshStatus($locked);
            $locked->refresh();

            if (! $locked->isPayable()) {
                throw ValidationException::withMessages(['invoice' => 'Invoice tidak sedang menunggu pembayaran.']);
            }

            $amount = (int) ($data['amount'] ?? 0);
            if ($amount < 1 || $amount > $locked->amount_due) {
                throw ValidationException::withMessages(['amount' => 'Pembayaran harus lebih dari 0 dan tidak boleh melebihi amount due.']);
            }

            $payment = $locked->payments()->create([
                'organization_id' => $locked->organization_id,
                'received_by' => $receiver->id,
                'amount' => $amount,
                'method' => $data['method'],
                'reference' => filled($data['reference'] ?? null) ? $data['reference'] : null,
                'paid_at' => $data['paid_at'] ?? now(),
                'notes' => filled($data['notes'] ?? null) ? $data['notes'] : null,
            ]);

            $this->recalculatePaymentStatus($locked);

            return $payment->fresh(['receiver', 'invoice']);
        });
    }

    public function refreshStatus(Invoice $invoice): Invoice
    {
        if (in_array($invoice->status, [InvoiceStatus::Draft, InvoiceStatus::Void, InvoiceStatus::Paid], true)) {
            return $invoice;
        }

        $status = $invoice->paid_amount >= $invoice->total_amount
            ? InvoiceStatus::Paid
            : ($invoice->due_date?->isPast() ? InvoiceStatus::Overdue : ($invoice->paid_amount > 0 ? InvoiceStatus::PartiallyPaid : InvoiceStatus::Issued));

        if ($invoice->status !== $status) {
            $invoice->update(['status' => $status]);
        }

        return $invoice->fresh();
    }

    private function recalculatePaymentStatus(Invoice $invoice): void
    {
        $paidAmount = (int) $invoice->payments()->sum('amount');
        $amountDue = max(0, $invoice->total_amount - $paidAmount);
        $status = $amountDue === 0
            ? InvoiceStatus::Paid
            : ($invoice->due_date?->isPast() ? InvoiceStatus::Overdue : ($paidAmount > 0 ? InvoiceStatus::PartiallyPaid : InvoiceStatus::Issued));

        $invoice->update([
            'paid_amount' => $paidAmount,
            'amount_due' => $amountDue,
            'status' => $status,
        ]);
    }

    private function ensureEditable(Invoice $invoice): void
    {
        if (! $invoice->isEditable()) {
            throw ValidationException::withMessages(['invoice' => 'Invoice yang sudah terbit tidak dapat diedit. Buat revisi jika ada koreksi.']);
        }
    }

    private function lockedWorkOrder(Organization $organization, mixed $workOrderId): ?WorkOrder
    {
        if (! filled($workOrderId)) {
            return null;
        }

        return WorkOrder::query()
            ->forOrganization($organization)
            ->whereKey((int) $workOrderId)
            ->lockForUpdate()
            ->firstOrFail();
    }
}
