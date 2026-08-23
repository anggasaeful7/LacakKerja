<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Service;
use App\Services\CurrentOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [Service::class, $organization]);
        $search = trim((string) $request->string('q'));
        $query = Service::query()->forOrganization($organization)->withCount('checklistTemplates');
        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('service_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('active')) {
            $query->where('is_active', $request->boolean('active'));
        }
        $services = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('pages.services.index', compact('services', 'organization', 'search'));
    }

    public function create(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Service::class, $organization]);

        return view('pages.services.form', ['service' => new Service(['is_active' => true]), 'organization' => $organization]);
    }

    public function store(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Service::class, $organization]);
        $validated = $this->validated($request);
        $service = $organization->services()->create([
            ...$validated,
            'service_code' => $validated['service_code'] ?? $this->nextCode($organization),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('services.index')->with('status', 'Layanan berhasil dibuat.');
    }

    public function edit(Request $request, Service $service): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $service);
        abort_unless($service->organization_id === $organization->id, 404);

        return view('pages.services.form', compact('service', 'organization'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $service);
        abort_unless($service->organization_id === $organization->id, 404);
        $validated = $this->validated($request);
        $service->update([...$validated, 'is_active' => $request->boolean('is_active')]);

        return redirect()->route('services.index')->with('status', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('delete', $service);
        abort_unless($service->organization_id === $organization->id, 404);
        $service->delete();

        return redirect()->route('services.index')->with('status', 'Layanan diarsipkan.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        return $request->validate([
            'service_code' => ['nullable', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration_minutes' => ['nullable', 'integer', 'min:1', 'max:10080'],
            'base_price' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function nextCode(Organization $organization): string
    {
        $number = $organization->services()->withTrashed()->count() + 1;
        do {
            $candidate = 'SVC-'.str_pad((string) $number++, 4, '0', STR_PAD_LEFT);
        } while ($organization->services()->withTrashed()->where('service_code', $candidate)->exists());

        return $candidate;
    }
}
