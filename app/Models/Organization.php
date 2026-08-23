<?php

namespace App\Models;

use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $timezone
 * @property string $currency
 * @property array<string, mixed>|null $settings
 */
#[Fillable(['name', 'slug', 'timezone', 'currency', 'settings'])]
class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

    /** @return HasMany<Customer, $this> */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /** @return HasMany<CustomerSite, $this> */
    public function customerSites(): HasMany
    {
        return $this->hasMany(CustomerSite::class);
    }

    /** @return HasMany<Asset, $this> */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    /** @return HasMany<Service, $this> */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /** @return HasMany<ChecklistTemplate, $this> */
    public function checklistTemplates(): HasMany
    {
        return $this->hasMany(ChecklistTemplate::class);
    }

    /** @return HasMany<WorkOrder, $this> */
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    /** @return HasMany<Invoice, $this> */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /** @return HasMany<TechnicianProfile, $this> */
    public function technicianProfiles(): HasMany
    {
        return $this->hasMany(TechnicianProfile::class);
    }

    /** @return HasMany<Membership, $this> */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /** @return BelongsToMany<User, $this, Pivot> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->withPivot(['role', 'status', 'joined_at', 'invited_at'])
            ->withTimestamps();
    }

    /** @return HasMany<Invitation, $this> */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /** @return HasMany<Membership, $this> */
    public function activeMembers(): HasMany
    {
        return $this->memberships()->where('status', MembershipStatus::Active->value);
    }

    public function ownerCount(): int
    {
        return $this->memberships()
            ->where('role', OrganizationRole::Owner->value)
            ->where('status', MembershipStatus::Active->value)
            ->count();
    }
}
