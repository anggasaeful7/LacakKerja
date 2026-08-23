<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\WorkOrder;
use App\Models\WorkOrderAssignment;
use App\Observers\InvoiceObserver;
use App\Observers\MembershipObserver;
use App\Observers\PaymentObserver;
use App\Observers\WorkOrderAssignmentObserver;
use App\Observers\WorkOrderObserver;
use App\Services\CurrentOrganization;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(CurrentOrganization::class);
    }

    public function boot(): void
    {
        $this->configureDefaults();
        WorkOrder::observe(WorkOrderObserver::class);
        WorkOrderAssignment::observe(WorkOrderAssignmentObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
        Membership::observe(MembershipObserver::class);
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
