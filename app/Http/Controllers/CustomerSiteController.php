<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Organization;
use App\Services\CurrentOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CustomerSiteController extends Controller
{
    public function create(Request $request, Customer $customer): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeCustomer($request, $customer, 'create');

        return view('pages.customers.sites.form', ['customer' => $customer, 'site' => new CustomerSite, 'organization' => $organization]);
    }

    public function store(Request $request, Customer $customer): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeCustomer($request, $customer, 'create');
        $validated = $this->validated($request);

        $this->ensureCustomerSiteBelongsToTenant($customer, $organization);
        $site = $customer->sites()->create([...$validated, 'organization_id' => $organization->id]);
        $this->syncDefault($site);

        return redirect()->route('customers.show', $customer)->with('status', 'Site berhasil ditambahkan.');
    }

    public function edit(Request $request, Customer $customer, CustomerSite $site): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeSite($request, $customer, $site, 'update');

        return view('pages.customers.sites.form', compact('customer', 'site', 'organization'));
    }

    public function update(Request $request, Customer $customer, CustomerSite $site): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        $this->authorizeSite($request, $customer, $site, 'update');
        $site->update($this->validated($request));
        $this->syncDefault($site);

        return redirect()->route('customers.show', $customer)->with('status', 'Site berhasil diperbarui.');
    }

    public function destroy(Request $request, Customer $customer, CustomerSite $site): RedirectResponse
    {
        $this->authorizeSite($request, $customer, $site, 'delete');
        $site->delete();

        return redirect()->route('customers.show', $customer)->with('status', 'Site diarsipkan.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'code' => ['nullable', 'string', 'max:32'],
            'contact_name' => ['nullable', 'string', 'max:160'],
            'contact_phone' => ['nullable', 'string', 'max:32'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80'],
            'province' => ['nullable', 'string', 'max:80'],
            'postal_code' => ['nullable', 'string', 'max:16'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'access_notes' => ['nullable', 'string', 'max:5000'],
            'is_default' => ['nullable', 'boolean'],
        ]);
    }

    private function syncDefault(CustomerSite $site): void
    {
        if ($site->is_default) {
            CustomerSite::query()->where('customer_id', $site->customer_id)->where('id', '!=', $site->id)->update(['is_default' => false]);
        } elseif (! CustomerSite::query()->where('customer_id', $site->customer_id)->where('is_default', true)->exists()) {
            $site->update(['is_default' => true]);
        }
    }

    private function authorizeCustomer(Request $request, Customer $customer, string $ability): void
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        abort_unless($customer->organization_id === $organization->id, 404);
        Gate::forUser($request->user())->authorize($ability, [CustomerSite::class, $organization]);
    }

    private function authorizeSite(Request $request, Customer $customer, CustomerSite $site, string $ability): void
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        abort_unless($site->organization_id === $organization->id && $site->customer_id === $customer->id, 404);
        Gate::forUser($request->user())->authorize($ability, $site);
    }

    private function ensureCustomerSiteBelongsToTenant(Customer $customer, Organization $organization): void
    {
        abort_unless($customer->organization_id === $organization->id, 404);
    }
}
