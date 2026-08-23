<?php

namespace App\Models;

use App\Enums\WorkOrderNoteVisibility;
use Carbon\CarbonImmutable;
use Database\Factories\WorkOrderNoteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $work_order_id
 * @property int|null $user_id
 * @property WorkOrderNoteVisibility $visibility
 * @property string $body
 * @property CarbonImmutable $created_at
 */
#[Fillable(['work_order_id', 'user_id', 'visibility', 'body'])]
class WorkOrderNote extends Model
{
    /** @use HasFactory<WorkOrderNoteFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'visibility' => WorkOrderNoteVisibility::class,
        ];
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /** @return BelongsTo<User, $this> */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
