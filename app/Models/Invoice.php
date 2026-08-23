<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\InvoiceStatus;
use Carbon\CarbonImmutable;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $organization_id
 * @property int $customer_id
 * @property int|null $work_order_id
 * @property int|null $revision_of_id
 * @property string $number
 * @property InvoiceStatus $status
 * @property string $currency
 * @property CarbonImmutable|null $issued_at
 * @property CarbonImmutable|null $due_date
 * @property int $subtotal
 * @property int $discount_amount
 * @property string $tax_rate
 * @property int $tax_amount
 * @property int $total_amount
 * @property int $paid_amount
 * @property int $amount_due
 * @property string|null $notes
 * @property CarbonImmutable|null $voided_at
 * @property string|null $void_reason
 */
#[Fillable(['organization_id', 'customer_id', 'work_order_id', 'revision_of_id', 'number', 'status', 'currency', 'issued_at', 'due_date', 'subtotal', 'discount_amount', 'tax_rate', 'tax_amount', 'total_amount', 'paid_amount', 'amount_due', 'notes', 'voided_at', 'void_reason'])]
class Invoice extends Model
{
    /** @use HasFactory<InvoiceFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'status' => InvoiceStatus::class,
            'issued_at' => 'immutable_datetime',
            'due_date' => 'immutable_date',
            'subtotal' => 'integer',
            'discount_amount' => 'integer',
            'tax_amount' => 'integer',
            'total_amount' => 'integer',
            'paid_amount' => 'integer',
            'amount_due' => 'integer',
            'voided_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<Customer, $this> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /** @return BelongsTo<Invoice, $this> */
    public function revisionOf(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'revision_of_id');
    }

    /** @return HasMany<Invoice, $this> */
    public function revisions(): HasMany
    {
        return $this->hasMany(Invoice::class, 'revision_of_id');
    }

    /** @return HasMany<InvoiceItem, $this> */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('id');
    }

    /** @return HasMany<Payment, $this> */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->latest('paid_at');
    }

    /** @param Builder<Invoice> $query
     * @return Builder<Invoice> */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $builder) use ($search): void {
            $builder->where('number', 'like', "%{$search}%")
                ->orWhereHas('customer', fn (Builder $customer): Builder => $customer->where('name', 'like', "%{$search}%"))
                ->orWhereHas('workOrder', fn (Builder $workOrder): Builder => $workOrder->where('number', 'like', "%{$search}%"));
        });
    }

    public function isEditable(): bool
    {
        return $this->status->isEditable();
    }

    public function isPayable(): bool
    {
        return $this->status->isPayable() && $this->amount_due > 0;
    }
}
