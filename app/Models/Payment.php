<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\PaymentMethod;
use Carbon\CarbonImmutable;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $organization_id
 * @property int $invoice_id
 * @property int|null $received_by
 * @property int $amount
 * @property PaymentMethod $method
 * @property string|null $reference
 * @property CarbonImmutable $paid_at
 * @property string|null $notes
 */
#[Fillable(['organization_id', 'invoice_id', 'received_by', 'amount', 'method', 'reference', 'paid_at', 'notes'])]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'method' => PaymentMethod::class,
            'amount' => 'integer',
            'paid_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<Invoice, $this> */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /** @return BelongsTo<User, $this> */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
