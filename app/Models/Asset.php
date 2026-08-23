<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\AssetStatus;
use Carbon\CarbonImmutable;
use Database\Factories\AssetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $organization_id
 * @property int $customer_id
 * @property int $customer_site_id
 * @property string $asset_identifier
 * @property string $qr_identifier
 * @property string $name
 * @property string $category
 * @property string|null $brand
 * @property string|null $model
 * @property string|null $serial_number
 * @property AssetStatus $status
 * @property CarbonImmutable|null $installation_date
 * @property string|null $notes
 */
#[Fillable(['organization_id', 'customer_id', 'customer_site_id', 'asset_identifier', 'qr_identifier', 'name', 'category', 'brand', 'model', 'serial_number', 'status', 'installation_date', 'notes'])]
class Asset extends Model
{
    /** @use HasFactory<AssetFactory> */
    use BelongsToOrganization, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => AssetStatus::class,
            'installation_date' => 'immutable_date',
        ];
    }

    /** @return BelongsTo<Customer, $this> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /** @return BelongsTo<CustomerSite, $this> */
    public function site(): BelongsTo
    {
        return $this->belongsTo(CustomerSite::class, 'customer_site_id');
    }

    public function qrUrl(): string
    {
        return route('assets.show', $this);
    }
}
