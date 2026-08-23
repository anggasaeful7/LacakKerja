<?php

use App\Enums\AssetStatus;
use App\Enums\OrganizationRole;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\User;

it('lets a dispatcher create a customer, site, and asset without leaving the flow', function () {
    $organization = Organization::factory()->create();
    $dispatcher = User::factory()->create();
    Membership::factory()->dispatcher()->create(['organization_id' => $organization->id, 'user_id' => $dispatcher->id]);
    $dispatcher->update(['current_organization_id' => $organization->id]);

    $this->actingAs($dispatcher)
        ->post(route('customers.store'), [
            'name' => 'PT Nusantara Teknik',
            'customer_type' => 'business',
            'email' => 'ops@nusantara.test',
            'phone' => '+62 811 1111 1111',
        ])
        ->assertRedirect();

    $customer = Customer::query()->where('name', 'PT Nusantara Teknik')->firstOrFail();
    $this->post(route('customers.sites.store', $customer), [
        'name' => 'Kantor Pusat',
        'address_line1' => 'Jl. Merdeka No. 1',
        'city' => 'Jakarta',
        'is_default' => '1',
    ])->assertRedirect(route('customers.show', $customer));

    $site = CustomerSite::query()->where('customer_id', $customer->id)->firstOrFail();
    $this->post(route('assets.store'), [
        'customer_id' => $customer->id,
        'customer_site_id' => $site->id,
        'name' => 'AC Lobby',
        'category' => 'AC Split',
        'status' => AssetStatus::Active->value,
        'installation_date' => '2026-01-10',
    ])->assertRedirect();

    $asset = Asset::query()->where('customer_id', $customer->id)->firstOrFail();
    expect($asset->organization_id)->toBe($organization->id);
    expect($asset->asset_identifier)->toStartWith('AST-');
    expect($asset->qr_identifier)->toStartWith('LK-QR-');
});

it('keeps customer and asset records isolated between organizations', function () {
    $organizationA = Organization::factory()->create();
    $organizationB = Organization::factory()->create();
    $userA = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organizationA->id, 'user_id' => $userA->id]);
    $userA->update(['current_organization_id' => $organizationA->id]);
    $customerB = Customer::factory()->create(['organization_id' => $organizationB->id]);
    $siteB = CustomerSite::factory()->forCustomer($customerB)->create();

    $this->actingAs($userA)
        ->get(route('customers.show', $customerB))
        ->assertForbidden();

    $this->post(route('assets.store'), [
        'customer_id' => $customerB->id,
        'customer_site_id' => $siteB->id,
        'name' => 'Cross tenant asset',
        'category' => 'AC',
        'status' => AssetStatus::Active->value,
    ])->assertNotFound();

    expect(Asset::query()->where('name', 'Cross tenant asset')->exists())->toBeFalse();
});

it('preserves customer search filters through server-side pagination', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);
    Customer::factory()->count(18)->create(['organization_id' => $organization->id]);
    Customer::factory()->create(['organization_id' => $organization->id, 'name' => 'Target Facility']);

    $response = $this->actingAs($owner)->get(route('customers.index', ['q' => 'Target', 'page' => 1]));
    $response->assertOk()->assertSee('Target Facility')->assertSee('name="q" value="Target"', false);
});

it('prevents technicians from changing master data', function () {
    $organization = Organization::factory()->create();
    $technician = User::factory()->create();
    Membership::factory()->create(['organization_id' => $organization->id, 'user_id' => $technician->id, 'role' => OrganizationRole::Technician]);
    $technician->update(['current_organization_id' => $organization->id]);

    $this->actingAs($technician)->get(route('customers.create'))->assertForbidden();
    $this->actingAs($technician)->get(route('assets.create'))->assertForbidden();
});
it('supports site update and archive within the same tenant', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);
    $customer = Customer::factory()->create(['organization_id' => $organization->id]);
    $site = CustomerSite::factory()->forCustomer($customer)->create(['organization_id' => $organization->id]);

    $this->actingAs($owner)->put(route('customers.sites.update', [$customer, $site]), [
        'name' => 'Site Updated',
        'address_line1' => 'Jl. Baru No. 2',
        'city' => 'Bandung',
    ])->assertRedirect();
    expect($site->fresh()->name)->toBe('Site Updated');

    $this->delete(route('customers.sites.destroy', [$customer, $site]))->assertRedirect();
    expect($site->fresh()->trashed())->toBeTrue();
});

it('allows a manager to create and update a service catalog entry', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);

    $this->actingAs($owner)->post(route('services.store'), [
        'name' => 'AC Installation',
        'description' => 'Pemasangan unit baru',
        'duration_minutes' => 240,
        'base_price' => 1500000,
        'is_active' => '1',
    ])->assertRedirect(route('services.index'));

    $service = Service::query()->where('name', 'AC Installation')->firstOrFail();
    expect($service->service_code)->toStartWith('SVC-');

    $this->put(route('services.update', $service), [
        'service_code' => $service->service_code,
        'name' => 'AC Installation Premium',
        'base_price' => 1750000,
        'is_active' => '1',
    ])->assertRedirect(route('services.index'));
    expect($service->fresh()->name)->toBe('AC Installation Premium');
});
