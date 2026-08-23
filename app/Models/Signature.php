<?php

namespace App\Models;

use Database\Factories\SignatureFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['work_order_id', 'signer_name', 'path', 'consent_version', 'signed_at'])]
class Signature extends Model
{
    /** @use HasFactory<SignatureFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'signed_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
