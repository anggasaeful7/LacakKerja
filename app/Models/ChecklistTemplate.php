<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\ChecklistStatus;
use Database\Factories\ChecklistTemplateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $organization_id
 * @property int|null $service_id
 * @property string $template_key
 * @property string $name
 * @property string|null $description
 * @property int $version
 * @property ChecklistStatus $status
 * @property bool $is_current
 * @property array<int, array<string, mixed>>|null $snapshot
 */
#[Fillable(['organization_id', 'service_id', 'template_key', 'name', 'description', 'version', 'status', 'is_current', 'published_at', 'snapshot'])]
class ChecklistTemplate extends Model
{
    /** @use HasFactory<ChecklistTemplateFactory> */
    use BelongsToOrganization, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => ChecklistStatus::class,
            'is_current' => 'boolean',
            'published_at' => 'immutable_datetime',
            'snapshot' => 'array',
        ];
    }

    /** @return BelongsTo<Service, $this> */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /** @return HasMany<ChecklistTemplateItem, $this> */
    public function items(): HasMany
    {
        return $this->hasMany(ChecklistTemplateItem::class)->orderBy('position');
    }

    /** @return array<int, array<string, mixed>> */
    public function snapshotPayload(): array
    {
        if ($this->snapshot !== null) {
            return $this->snapshot;
        }

        return $this->items->map(fn (ChecklistTemplateItem $item): array => $item->toSnapshot())->values()->all();
    }

    public function publishSnapshot(): void
    {
        $this->update([
            'status' => ChecklistStatus::Published,
            'is_current' => true,
            'published_at' => now(),
            'snapshot' => $this->items()->get()->map(fn (ChecklistTemplateItem $item): array => $item->toSnapshot())->values()->all(),
        ]);
    }
}
