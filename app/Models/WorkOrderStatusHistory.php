<?php

namespace App\Models;

use App\Enums\WorkOrderStatus;
use Database\Factories\WorkOrderStatusHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property WorkOrderStatus|null $from_status
 * @property WorkOrderStatus $to_status
 */
#[Fillable(['work_order_id', 'changed_by', 'from_status', 'to_status', 'reason', 'created_at'])]
class WorkOrderStatusHistory extends Model
{
    /** @use HasFactory<WorkOrderStatusHistoryFactory> */
    use HasFactory;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'from_status' => WorkOrderStatus::class,
            'to_status' => WorkOrderStatus::class,
            'created_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /** @return BelongsTo<User, $this> */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
