<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $organization_id
 * @property string $customer_number
 * @property string $name
 * @property string $customer_type
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $tax_id
 * @property string|null $notes
 */
#[Fillable(['organization_id', 'customer_number', 'name', 'customer_type', 'email', 'phone', 'tax_id', 'notes'])]
class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use BelongsToOrganization, HasFactory, SoftDeletes;

    /** @return HasMany<Invoice, $this> */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /** @return HasMany<CustomerSite, $this> */
    public function sites(): HasMany
    {
        return $this->hasMany(CustomerSite::class);
    }

    /** @return HasMany<Asset, $this> */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
