<?php

use App\Enums\WorkOrderStatus;
use App\Jobs\DeliverNotificationEmail;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

function m11Fixture(): array
{
    $organization = Organization::factory()->create(['timezone' => 'Asia/Jakarta']);
    $owner = User::factory()->create(['current_organization_id' => $organization->id]);
    Membership::factory()->owner()->create([
        'organization_id' => $organization->id,
        'user_id' => $owner->id,
    ]);
    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->create([
        'organization_id' => $organization->id,
        'customer_id' => $customer->id,
    ]);
    $service = Service::factory()->create(['organization_id' => $organization->id]);
    $workOrder = WorkOrder::factory()->forCustomer($customer, $site)->create([
        'organization_id' => $organization->id,
        'service_id' => $service->id,
        'status' => WorkOrderStatus::Scheduled,
        'scheduled_start' => now()->addHour(),
        'scheduled_end' => now()->addHours(2),
    ]);

    return compact('organization', 'owner', 'customer', 'site', 'service', 'workOrder');
}

it('reports database, private storage, and queue health without internals', function () {
    $response = $this->getJson(route('health'));

    $response->assertOk()
        ->assertJsonStructure(['status', 'checks' => ['database', 'storage', 'queue']])
        ->assertJsonPath('status', 'ok')
        ->assertDontSee('SQLSTATE')
        ->assertDontSee('APP_KEY');
});

it('protects authenticated operational routes from anonymous access', function () {
    foreach ([route('dashboard'), route('work-orders.index'), route('invoices.index'), route('notifications.index')] as $url) {
        $this->get($url)->assertRedirect();
    }
});

it('renders a safe not-found state without a debug trace', function () {
    $this->get('/m11-route-that-does-not-exist')
        ->assertNotFound()
        ->assertSee('Halaman tidak ditemukan')
        ->assertDontSee('vendor/laravel/framework')
        ->assertDontSee('APP_KEY');
});

it('keeps scheduler idempotency and failed-job retry configuration wired', function () {
    Artisan::call('schedule:list');

    expect(Artisan::output())->toContain('lacakkerja:send-reminders')
        ->and(config('queue.failed.driver'))->toBe('database-uuids');

    $job = new DeliverNotificationEmail(1, 1, 'assigned', ['title' => 'QA']);
    expect($job->tries)->toBe(3)->and($job->backoff)->toBe([60, 300]);
});

it('rejects disallowed upload MIME and extension combinations', function () {
    $fixture = m11Fixture();

    $this->actingAs($fixture['owner'])
        ->post(route('work-orders.attachments.store', $fixture['workOrder']), [
            'file' => UploadedFile::fake()->create('payload.txt', 1, 'text/plain'),
            'category' => 'evidence',
        ])
        ->assertSessionHasErrors('file');

    expect($fixture['workOrder']->attachments()->count())->toBe(0);
});
it('keeps data-heavy work order listing paginated with bounded queries', function () {
    $fixture = m11Fixture();
    WorkOrder::factory()->count(30)->forCustomer($fixture['customer'], $fixture['site'])->create([
        'organization_id' => $fixture['organization']->id,
        'service_id' => $fixture['service']->id,
        'status' => WorkOrderStatus::Scheduled,
        'scheduled_start' => now()->addHour(),
        'scheduled_end' => now()->addHours(2),
    ]);

    $queries = 0;
    DB::listen(function () use (&$queries): void {
        $queries++;
    });

    $this->actingAs($fixture['owner'])
        ->get(route('work-orders.index', ['page' => 2, 'status' => 'scheduled']))
        ->assertOk();

    expect($queries)->toBeLessThan(20);
});

it('passes the authenticated golden-path HTTP smoke flow', function () {
    $fixture = m11Fixture();
    $user = $fixture['owner'];

    $this->actingAs($user)->get(route('dashboard'))->assertOk();
    $this->actingAs($user)->get(route('work-orders.index'))->assertOk();
    $this->actingAs($user)->get(route('work-orders.show', $fixture['workOrder']))->assertOk();
    $this->actingAs($user)->get(route('notifications.index'))->assertOk();
    $this->actingAs($user)->get(route('invoices.index'))->assertOk();
});
