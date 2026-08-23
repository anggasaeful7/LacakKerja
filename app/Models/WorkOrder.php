<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use Carbon\CarbonImmutable;
use Database\Factories\WorkOrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $organization_id
 * @property int $customer_id
 * @property int $customer_site_id
 * @property int|null $asset_id
 * @property int|null $service_id
 * @property int|null $created_by
 * @property string $number
 * @property string $title
 * @property string|null $description
 * @property WorkOrderPriority $priority
 * @property WorkOrderStatus $status
 * @property CarbonImmutable|null $scheduled_start
 * @property CarbonImmutable|null $scheduled_end
 * @property CarbonImmutable|null $sla_due_at
 * @property CarbonImmutable|null $completed_at
 * @property int $estimated_total
 * @property int $lock_version
 */
#[Fillable(['organization_id', 'customer_id', 'customer_site_id', 'asset_id', 'service_id', 'created_by', 'number', 'title', 'description', 'priority', 'status', 'scheduled_start', 'scheduled_end', 'sla_due_at', 'completed_at', 'estimated_total', 'lock_version'])]
class WorkOrder extends Model
{
    /** @use HasFactory<WorkOrderFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'priority' => WorkOrderPriority::class,
            'status' => WorkOrderStatus::class,
            'scheduled_start' => 'immutable_datetime',
            'scheduled_end' => 'immutable_datetime',
            'sla_due_at' => 'immutable_datetime',
            'completed_at' => 'immutable_datetime',
            'estimated_total' => 'integer',
            'lock_version' => 'integer',
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

    /** @return BelongsTo<Asset, $this> */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /** @return BelongsTo<Service, $this> */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /** @return BelongsTo<User, $this> */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** @return HasMany<WorkOrderAssignment, $this> */
    public function assignments(): HasMany
    {
        return $this->hasMany(WorkOrderAssignment::class);
    }

    /** @return HasOne<WorkOrderAssignment, $this> */
    public function primaryAssignment(): HasOne
    {
        return $this->hasOne(WorkOrderAssignment::class)->where('is_primary', true);
    }

    /** @return HasMany<WorkOrderStatusHistory, $this> */
    public function statusHistories(): HasMany
    {
        return $this->hasMany(WorkOrderStatusHistory::class)->latest('created_at');
    }

    /** @return HasMany<WorkOrderChecklistItem, $this> */
    public function checklistItems(): HasMany
    {
        return $this->hasMany(WorkOrderChecklistItem::class)->orderBy('sort_order');
    }

    /** @return HasMany<WorkOrderNote, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(WorkOrderNote::class)->latest();
    }

    /** @return HasMany<Attachment, $this> */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class)->latest();
    }

    /** @return HasMany<TimeLog, $this> */
    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class)->latest('started_at');
    }

    /** @return HasMany<MaterialUsage, $this> */
    public function materialUsages(): HasMany
    {
        return $this->hasMany(MaterialUsage::class)->latest();
    }

    /** @return HasOne<Signature, $this> */
    public function signature(): HasOne
    {
        return $this->hasOne(Signature::class);
    }

    /** @return HasMany<Invoice, $this> */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /** @param Builder<WorkOrder> $query
     * @return Builder<WorkOrder> */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $builder) use ($search): void {
            $builder->where('number', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhereHas('customer', fn (Builder $customer) => $customer->where('name', 'like', "%{$search}%"))
                ->orWhereHas('customer', fn (Builder $customer) => $customer->where('phone', 'like', "%{$search}%"));
        });
    }

    public function isLocked(): bool
    {
        return $this->status->isTerminal();
    }

    public function isOverdue(): bool
    {
        return $this->sla_due_at !== null
            && $this->sla_due_at->isPast()
            && ! $this->status->isTerminal();
    }

    public function hasPrimaryTechnician(): bool
    {
        return $this->relationLoaded('primaryAssignment')
            ? $this->primaryAssignment !== null
            : $this->primaryAssignment()->exists();
    }

    public function scheduleIsValid(): bool
    {
        return $this->scheduled_start !== null
            && $this->scheduled_end !== null
            && $this->scheduled_end->greaterThan($this->scheduled_start);
    }
}
