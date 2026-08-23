<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config(['demo.password' => 'demo-password-1234']);
});

it('seeds and resets the demo pack idempotently', function (): void {
    $this->artisan('lacakkerja:demo-reset')
        ->assertSuccessful();

    $this->assertDatabaseHas('organizations', ['slug' => 'lacakkerja-demo']);
    $this->assertDatabaseHas('users', ['email' => 'dispatcher@lacakkerja.test']);
    $this->assertDatabaseHas('users', ['email' => 'technician1@lacakkerja.test']);
    expect(User::query()->where('email', 'technician1@lacakkerja.test')->value('email_verified_at'))->not->toBeNull();

    $organization = Organization::query()->where('slug', 'lacakkerja-demo')->firstOrFail();
    $firstCounts = [
        'customers' => $organization->customers()->count(),
        'work_orders' => $organization->workOrders()->count(),
        'invoices' => $organization->invoices()->count(),
    ];

    $this->artisan('lacakkerja:demo-reset')
        ->assertSuccessful();

    $organization = Organization::query()->where('slug', 'lacakkerja-demo')->firstOrFail();
    expect([
        'customers' => $organization->customers()->count(),
        'work_orders' => $organization->workOrders()->count(),
        'invoices' => $organization->invoices()->count(),
    ])->toBe($firstCounts);

    expect(Hash::check('demo-password-1234', User::query()->where('email', 'dispatcher@lacakkerja.test')->value('password')))->toBeTrue();
});

it('refuses production reset without an explicit force flag', function (): void {
    config(['app.env' => 'production']);

    $this->artisan('lacakkerja:demo-reset')
        ->assertFailed();
});
