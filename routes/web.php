<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ChecklistTemplateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerSiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispatchController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('health', HealthController::class)->name('health');

Route::get('invitations/{token}', [InvitationController::class, 'show'])
    ->where('token', '[A-Za-z0-9]+')
    ->name('invitations.show');

Route::middleware(['auth'])->group(function () {
    Route::get('onboarding/organization', [OrganizationController::class, 'onboarding'])->name('onboarding.organization');
    Route::post('onboarding/organization', [OrganizationController::class, 'store'])->name('onboarding.organization.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('organization/switch', [OrganizationController::class, 'switch'])
        ->middleware('organization')
        ->name('organization.switch');

    Route::middleware('organization')->group(function (): void {
        Route::get('technician/today', [TechnicianController::class, 'today'])->name('technician.today');
        Route::get('technician/tasks', [TechnicianController::class, 'tasks'])->name('technician.tasks');
        Route::get('technician/sync', [TechnicianController::class, 'syncCenter'])->name('technician.sync.center');
        Route::get('technician/sync/bootstrap', [TechnicianController::class, 'syncBootstrap'])->middleware('throttle:60,1')->name('technician.sync.bootstrap');
        Route::post('technician/sync/batch', [TechnicianController::class, 'syncBatch'])->middleware('throttle:60,1')->name('technician.sync.batch');
        Route::get('technician/work-orders/{workOrder}', [TechnicianController::class, 'show'])->name('technician.work-orders.show');
        Route::post('technician/work-orders/{workOrder}/transition', [TechnicianController::class, 'transition'])->name('technician.work-orders.transition');
        Route::patch('technician/work-orders/{workOrder}/checklist/{item}', [TechnicianController::class, 'updateChecklist'])->name('technician.work-orders.checklist.update');
        Route::post('technician/work-orders/{workOrder}/time/start', [TechnicianController::class, 'startTime'])->name('technician.work-orders.time.start');
        Route::post('technician/work-orders/{workOrder}/time/{timeLog}/stop', [TechnicianController::class, 'stopTime'])->name('technician.work-orders.time.stop');
        Route::post('technician/work-orders/{workOrder}/notes', [TechnicianController::class, 'addNote'])->name('technician.work-orders.notes.store');
        Route::post('technician/work-orders/{workOrder}/photos', [TechnicianController::class, 'uploadPhoto'])->name('technician.work-orders.photos.store');
        Route::get('technician/work-orders/{workOrder}/attachments/{attachment}', [TechnicianController::class, 'downloadAttachment'])->name('technician.work-orders.attachments.download');
        Route::post('technician/work-orders/{workOrder}/materials', [TechnicianController::class, 'addMaterial'])->name('technician.work-orders.materials.store');
        Route::post('technician/work-orders/{workOrder}/signature', [TechnicianController::class, 'storeSignature'])->name('technician.work-orders.signature.store');
        Route::post('technician/work-orders/{workOrder}/complete', [TechnicianController::class, 'complete'])->name('technician.work-orders.complete');
        Route::get('technician/work-orders/{workOrder}/success', [TechnicianController::class, 'success'])->name('technician.work-orders.success');

        Route::get('settings/organization', [OrganizationController::class, 'settings'])->name('organization.settings');
        Route::put('settings/organization', [OrganizationController::class, 'update'])->name('organization.settings.update');

        Route::get('organization/members', [OrganizationController::class, 'members'])->name('organization.members');
        Route::post('organization/invitations', [OrganizationController::class, 'invite'])->name('organization.invitations.store');
        Route::patch('organization/members/{membership}', [OrganizationController::class, 'updateMembership'])->name('organization.members.update');
        Route::delete('organization/members/{membership}', [OrganizationController::class, 'removeMembership'])->name('organization.members.destroy');
        Route::resource('customers', CustomerController::class)->except(['show']);
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('customers/{customer}/sites/create', [CustomerSiteController::class, 'create'])->name('customers.sites.create');
        Route::post('customers/{customer}/sites', [CustomerSiteController::class, 'store'])->name('customers.sites.store');
        Route::get('customers/{customer}/sites/{site}/edit', [CustomerSiteController::class, 'edit'])->name('customers.sites.edit');
        Route::put('customers/{customer}/sites/{site}', [CustomerSiteController::class, 'update'])->name('customers.sites.update');
        Route::delete('customers/{customer}/sites/{site}', [CustomerSiteController::class, 'destroy'])->name('customers.sites.destroy');

        Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
        Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
        Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::get('assets/{asset}', [AssetController::class, 'show'])->name('assets.show');
        Route::put('assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');

        Route::resource('services', ServiceController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::get('dispatch', [DispatchController::class, 'index'])->name('dispatch.index');
        Route::post('dispatch/work-orders/{workOrder}/schedule', [DispatchController::class, 'schedule'])->name('dispatch.schedule');
        Route::get('dispatch/technicians/{user}/edit', [DispatchController::class, 'editTechnician'])->name('dispatch.technicians.edit');
        Route::patch('dispatch/technicians/{user}', [DispatchController::class, 'updateTechnician'])->name('dispatch.technicians.update');

        Route::get('reports/operations', [ReportController::class, 'operations'])->name('reports.operations');
        Route::get('reports/operations/export', [ReportController::class, 'exportOperations'])->name('reports.operations.export');
        Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('reports/revenue/export', [ReportController::class, 'exportRevenue'])->name('reports.revenue.export');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

        Route::patch('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');

        Route::post('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');

        Route::get('settings/notifications', [NotificationPreferenceController::class, 'edit'])->name('notifications.preferences.edit');

        Route::put('settings/notifications', [NotificationPreferenceController::class, 'update'])->name('notifications.preferences.update');

        Route::get('audit-log', [ActivityLogController::class, 'index'])->name('audit.index');

        Route::get('work-orders', [WorkOrderController::class, 'index'])->name('work-orders.index');
        Route::get('work-orders/create', [WorkOrderController::class, 'create'])->name('work-orders.create');
        Route::post('work-orders', [WorkOrderController::class, 'store'])->name('work-orders.store');
        Route::get('work-orders/{workOrder}/edit', [WorkOrderController::class, 'edit'])->name('work-orders.edit');
        Route::put('work-orders/{workOrder}', [WorkOrderController::class, 'update'])->name('work-orders.update');
        Route::get('work-orders/{workOrder}', [WorkOrderController::class, 'show'])->name('work-orders.show');
        Route::post('work-orders/{workOrder}/transition', [WorkOrderController::class, 'transition'])->name('work-orders.transition');
        Route::post('work-orders/{workOrder}/complete', [WorkOrderController::class, 'complete'])->name('work-orders.complete');
        Route::post('work-orders/{workOrder}/notes', [WorkOrderController::class, 'addNote'])->name('work-orders.notes.store');
        Route::patch('work-orders/{workOrder}/checklist/{item}', [WorkOrderController::class, 'updateChecklist'])->name('work-orders.checklist.update');
        Route::post('work-orders/{workOrder}/time/start', [WorkOrderController::class, 'startTime'])->name('work-orders.time.start');
        Route::post('work-orders/{workOrder}/time/{timeLog}/stop', [WorkOrderController::class, 'stopTime'])->name('work-orders.time.stop');
        Route::post('work-orders/{workOrder}/attachments', [WorkOrderController::class, 'uploadAttachment'])->name('work-orders.attachments.store');
        Route::get('work-orders/{workOrder}/attachments/{attachment}', [WorkOrderController::class, 'downloadAttachment'])->name('work-orders.attachments.download');
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
        Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('invoices/{invoice}/issue', [InvoiceController::class, 'issue'])->name('invoices.issue');
        Route::post('invoices/{invoice}/void', [InvoiceController::class, 'void'])->name('invoices.void');
        Route::post('invoices/{invoice}/revise', [InvoiceController::class, 'revise'])->name('invoices.revise');
        Route::post('invoices/{invoice}/payments', [InvoiceController::class, 'storePayment'])->name('invoices.payments.store');

        Route::get('checklists', [ChecklistTemplateController::class, 'index'])->name('checklists.index');
        Route::get('checklists/create', [ChecklistTemplateController::class, 'create'])->name('checklists.create');
        Route::post('checklists', [ChecklistTemplateController::class, 'store'])->name('checklists.store');
        Route::get('checklists/{template}/versions/create', [ChecklistTemplateController::class, 'newVersion'])->name('checklists.versions.create');
        Route::post('checklists/{template}/publish', [ChecklistTemplateController::class, 'publish'])->name('checklists.publish');
        Route::get('checklists/{template}/edit', [ChecklistTemplateController::class, 'edit'])->name('checklists.edit');
        Route::put('checklists/{template}', [ChecklistTemplateController::class, 'update'])->name('checklists.update');
        Route::get('checklists/{template}', [ChecklistTemplateController::class, 'show'])->name('checklists.show');
        Route::delete('checklists/{template}', [ChecklistTemplateController::class, 'destroy'])->name('checklists.destroy');
    });

    Route::post('invitations/{token}/accept', [InvitationController::class, 'accept'])
        ->where('token', '[A-Za-z0-9]+')
        ->name('invitations.accept');
    Route::post('invitations/{token}/decline', [InvitationController::class, 'decline'])
        ->where('token', '[A-Za-z0-9]+')
        ->name('invitations.decline');
});

require __DIR__.'/settings.php';
