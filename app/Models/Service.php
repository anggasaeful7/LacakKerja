<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $organization_id
 * @property string $service_code
 * @property string $name
 * @property string|null $description
 * @property int|null $duration_minutes
 * @property float $base_price
 * @property bool $is_active
 */
#[Fillable(['organization_id', 'service_code', 'name', 'description', 'duration_minutes', 'base_price', 'is_active'])]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use BelongsToOrganization, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'base_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /** @return HasMany<ChecklistTemplate, $this> */
    public function checklistTemplates(): HasMany
    {
        return $this->hasMany(ChecklistTemplate::class);
    }
}
