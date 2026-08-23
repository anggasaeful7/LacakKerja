<?php

namespace App\Models;

use Database\Factories\WorkOrderAssignmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['work_order_id', 'user_id', 'is_primary', 'assigned_at', 'acknowledged_at'])]
class WorkOrderAssignment extends Model
{
    /** @use HasFactory<WorkOrderAssignmentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'assigned_at' => 'immutable_datetime',
            'acknowledged_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
