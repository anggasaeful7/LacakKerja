<?php

namespace App\Http\Controllers;

use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Organization;
use App\Services\CurrentOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [Asset::class, $organization]);

        $search = trim((string) $request->string('q'));
        $query = Asset::query()->forOrganization($organization)->with(['customer', 'site']);
        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('asset_identifier', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }
        if ($request->filled('customer_id')) {
            $query->where('customer_id', (int) $request->input('customer_id'));
        }

        $assets = $query->orderBy($request->input('sort') === 'name' ? 'name' : 'created_at', $request->input('direction') === 'asc' ? 'asc' : 'desc')
            ->paginate(15)->withQueryString();
        $customers = Customer::query()->forOrganization($organization)->orderBy('name')->get(['id', 'name']);

        return view('pages.assets.index', compact('assets', 'customers', 'organization', 'search'));
    }

    public function create(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Asset::class, $organization]);

        return view('pages.assets.form', [
            'asset' => new Asset(['status' => AssetStatus::Active]),
            'customers' => Customer::query()->forOrganization($organization)->with('sites')->orderBy('name')->get(),
            'organization' => $organization,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Asset::class, $organization]);
        $validated = $this->validated($request);
        [$customer, $site] = $this->resolveCustomerSite($organization, $validated);

        $asset = $organization->assets()->create([
            ...$validated,
            'customer_id' => $customer->id,
            'customer_site_id' => $site->id,
            'asset_identifier' => $this->nextIdentifier($organization),
            'qr_identifier' => $this->nextQrIdentifier($organization),
        ]);

        return redirect()->route('assets.show', $asset)->with('status', 'Aset berhasil dibuat.');
    }

    public function show(Request $request, Asset $asset): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $asset);
        abort_unless($asset->organization_id === $organization->id, 404);
        $asset->load(['customer', 'site']);

        return view('pages.assets.show', compact('asset', 'organization'));
    }

    public function edit(Request $request, Asset $asset): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $asset);
        abort_unless($asset->organization_id === $organization->id, 404);

        return view('pages.assets.form', [
            'asset' => $asset,
            'customers' => Customer::query()->forOrganization($organization)->with('sites')->orderBy('name')->get(),
            'organization' => $organization,
        ]);
    }

    public function update(Request $request, Asset $asset): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $asset);
        abort_unless($asset->organization_id === $organization->id, 404);
        $validated = $this->validated($request);
        [$customer, $site] = $this->resolveCustomerSite($organization, $validated);
        $asset->update([...$validated, 'customer_id' => $customer->id, 'customer_site_id' => $site->id]);

        return redirect()->route('assets.show', $asset)->with('status', 'Aset berhasil diperbarui.');
    }

    public function destroy(Request $request, Asset $asset): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('delete', $asset);
        abort_unless($asset->organization_id === $organization->id, 404);
        $asset->delete();

        return redirect()->route('assets.index')->with('status', 'Aset diarsipkan.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'integer'],
            'customer_site_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::enum(AssetStatus::class)],
            'installation_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array{0: Customer, 1: CustomerSite}
     */
    private function resolveCustomerSite(Organization $organization, array $validated): array
    {
        $customer = Customer::query()->forOrganization($organization)->whereKey((int) $validated['customer_id'])->firstOrFail();
        $site = CustomerSite::query()->forOrganization($organization)
            ->where('customer_id', $customer->id)
            ->whereKey((int) $validated['customer_site_id'])->firstOrFail();

        return [$customer, $site];
    }

    private function nextIdentifier(Organization $organization): string
    {
        $number = $organization->assets()->withTrashed()->count() + 1;
        do {
            $candidate = 'AST-'.str_pad((string) $number++, 6, '0', STR_PAD_LEFT);
        } while ($organization->assets()->withTrashed()->where('asset_identifier', $candidate)->exists());

        return $candidate;
    }

    private function nextQrIdentifier(Organization $organization): string
    {
        do {
            $candidate = 'LK-QR-'.Str::upper(Str::random(10));
        } while ($organization->assets()->withTrashed()->where('qr_identifier', $candidate)->exists());

        return $candidate;
    }
}
