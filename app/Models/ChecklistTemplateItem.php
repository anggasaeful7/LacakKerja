<?php

namespace App\Models;

use App\Enums\ChecklistInputType;
use Database\Factories\ChecklistTemplateItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $checklist_template_id
 * @property int $position
 * @property string $label
 * @property ChecklistInputType $input_type
 * @property bool $is_required
 * @property bool $photo_required
 * @property array<int, string>|null $options
 * @property string|null $help_text
 */
#[Fillable(['checklist_template_id', 'position', 'label', 'input_type', 'is_required', 'photo_required', 'options', 'help_text'])]
class ChecklistTemplateItem extends Model
{
    /** @use HasFactory<ChecklistTemplateItemFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'input_type' => ChecklistInputType::class,
            'is_required' => 'boolean',
            'photo_required' => 'boolean',
            'options' => 'array',
        ];
    }

    /** @return BelongsTo<ChecklistTemplate, $this> */
    public function template(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }

    /** @return array<string, mixed> */
    public function toSnapshot(): array
    {
        return [
            'position' => $this->position,
            'label' => $this->label,
            'input_type' => $this->input_type->value,
            'is_required' => $this->is_required,
            'photo_required' => $this->photo_required,
            'options' => $this->options ?? [],
            'help_text' => $this->help_text,
        ];
    }
}
