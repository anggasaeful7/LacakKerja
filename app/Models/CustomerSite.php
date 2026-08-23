<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use Database\Factories\CustomerSiteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $organization_id
 * @property int $customer_id
 * @property string $name
 * @property string|null $code
 * @property string $address_line1
 * @property string|null $address_line2
 * @property string|null $city
 * @property string|null $province
 * @property string|null $postal_code
 * @property string|null $contact_name
 * @property string|null $contact_phone
 * @property string|null $contact_email
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $access_notes
 * @property bool $is_default
 */
#[Fillable(['organization_id', 'customer_id', 'name', 'code', 'contact_name', 'contact_phone', 'contact_email', 'address_line1', 'address_line2', 'city', 'province', 'postal_code', 'latitude', 'longitude', 'access_notes', 'is_default'])]
class CustomerSite extends Model
{
    /** @use HasFactory<CustomerSiteFactory> */
    use BelongsToOrganization, HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_default' => 'boolean',
        ];
    }

    /** @return BelongsTo<Customer, $this> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /** @return HasMany<Asset, $this> */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function fullAddress(): string
    {
        return collect([$this->address_line1, $this->address_line2, $this->city, $this->province, $this->postal_code])
            ->filter()
            ->implode(', ');
    }
}
