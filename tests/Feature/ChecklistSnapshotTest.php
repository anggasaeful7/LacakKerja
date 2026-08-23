<?php

use App\Enums\ChecklistStatus;
use App\Models\ChecklistTemplate;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Service;
use App\Models\User;

it('publishes immutable checklist snapshots and creates a new editable version', function () {
    $organization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);
    $service = Service::factory()->create(['organization_id' => $organization->id]);

    $this->actingAs($owner)->post(route('checklists.store'), [
        'service_id' => $service->id,
        'template_key' => 'hvac.preventive',
        'name' => 'HVAC Preventive',
        'description' => 'Baseline checklist',
        'items' => [
            ['label' => 'Filter bersih', 'input_type' => 'checkbox', 'is_required' => '1', 'photo_required' => '1'],
            ['label' => 'Suhu', 'input_type' => 'number', 'is_required' => '1'],
        ],
    ])->assertRedirect();

    $template = ChecklistTemplate::query()->where('template_key', 'hvac.preventive')->firstOrFail();
    $this->post(route('checklists.publish', $template))->assertRedirect();
    $published = $template->fresh();
    expect($published->status)->toBe(ChecklistStatus::Published);
    expect($published->snapshot)->toHaveCount(2);
    $oldSnapshot = $published->snapshot;

    $this->actingAs($owner)->get(route('checklists.versions.create', $published))->assertRedirect();
    $versionTwo = ChecklistTemplate::query()->where('template_key', 'hvac.preventive')->where('version', 2)->firstOrFail();
    expect($versionTwo->status)->toBe(ChecklistStatus::Draft);
    expect($versionTwo->items)->toHaveCount(2);

    $this->put(route('checklists.update', $versionTwo), [
        'service_id' => $service->id,
        'template_key' => 'hvac.preventive',
        'name' => 'HVAC Preventive v2',
        'items' => [
            ['label' => 'Filter dan evaporator bersih', 'input_type' => 'checkbox', 'is_required' => '1'],
            ['label' => 'Tekanan refrigeran', 'input_type' => 'number'],
            ['label' => 'Foto panel', 'input_type' => 'text', 'photo_required' => '1'],
        ],
    ])->assertRedirect();

    $this->post(route('checklists.publish', $versionTwo->fresh()))->assertRedirect();
    expect($published->fresh()->snapshot)->toBe($oldSnapshot);
    expect($versionTwo->fresh()->snapshot)->toHaveCount(3);
});

it('rejects a checklist linked to a service from another organization', function () {
    $organization = Organization::factory()->create();
    $otherOrganization = Organization::factory()->create();
    $owner = User::factory()->create();
    Membership::factory()->owner()->create(['organization_id' => $organization->id, 'user_id' => $owner->id]);
    $owner->update(['current_organization_id' => $organization->id]);
    $foreignService = Service::factory()->create(['organization_id' => $otherOrganization->id]);

    $this->actingAs($owner)->post(route('checklists.store'), [
        'service_id' => $foreignService->id,
        'template_key' => 'foreign.service',
        'name' => 'Should fail',
        'items' => [],
    ])->assertNotFound();
});
