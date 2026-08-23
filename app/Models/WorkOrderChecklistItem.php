<?php

namespace App\Models;

use App\Enums\ChecklistInputType;
use Database\Factories\WorkOrderChecklistItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $work_order_id
 * @property int|null $completed_by
 * @property int $sort_order
 * @property string $label
 * @property ChecklistInputType $input_type
 * @property bool $is_required
 * @property bool $photo_required
 * @property array<int, string>|null $options
 * @property array<string, mixed>|null $value
 */
#[Fillable(['work_order_id', 'completed_by', 'sort_order', 'label', 'input_type', 'is_required', 'photo_required', 'options', 'value', 'completed_at'])]
class WorkOrderChecklistItem extends Model
{
    /** @use HasFactory<WorkOrderChecklistItemFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'input_type' => ChecklistInputType::class,
            'is_required' => 'boolean',
            'photo_required' => 'boolean',
            'options' => 'array',
            'value' => 'array',
            'completed_at' => 'immutable_datetime',
        ];
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /** @return BelongsTo<User, $this> */
    public function completer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function isComplete(): bool
    {
        return $this->value !== null;
    }
}
