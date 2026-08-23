<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Organization;
use App\Services\CurrentOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [Customer::class, $organization]);

        $query = Customer::query()->forOrganization($organization)->withCount(['sites', 'assets']);
        $search = trim((string) $request->string('q'));
        $sort = (string) $request->input('sort', 'name');
        $direction = (string) $request->input('direction', 'asc');

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('customer_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('customer_type', $request->string('type')->toString());
        }

        $allowedSorts = ['name', 'customer_number', 'created_at'];
        $query->orderBy(in_array($sort, $allowedSorts, true) ? $sort : 'name', $direction === 'desc' ? 'desc' : 'asc');

        $customers = $query->paginate(15)->withQueryString();

        return view('pages.customers.index', compact('customers', 'organization', 'search', 'sort', 'direction'));
    }

    public function create(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Customer::class, $organization]);

        return view('pages.customers.form', ['customer' => new Customer, 'organization' => $organization]);
    }

    public function store(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Customer::class, $organization]);
        $validated = $this->validated($request);

        if ($this->isDuplicate($organization, $validated) && ! $request->boolean('confirm_duplicate')) {
            return back()->withInput()->with('duplicate_warning', 'Customer dengan nama atau email yang sama sudah ada. Periksa kembali sebelum menyimpan.');
        }

        $customer = $organization->customers()->create([
            ...$validated,
            'customer_number' => $this->nextCustomerNumber($organization),
        ]);

        return redirect()->route('customers.show', $customer)->with('status', 'Customer berhasil dibuat.');
    }

    public function show(Request $request, Customer $customer): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $customer);
        abort_unless($customer->organization_id === $organization->id, 404);

        $customer->load(['sites.assets']);

        return view('pages.customers.show', compact('customer', 'organization'));
    }

    public function edit(Request $request, Customer $customer): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $customer);
        abort_unless($customer->organization_id === $organization->id, 404);

        return view('pages.customers.form', compact('customer', 'organization'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $customer);
        abort_unless($customer->organization_id === $organization->id, 404);
        $validated = $this->validated($request);

        if ($this->isDuplicate($organization, $validated, $customer) && ! $request->boolean('confirm_duplicate')) {
            return back()->withInput()->with('duplicate_warning', 'Customer dengan nama atau email yang sama sudah ada. Periksa kembali sebelum menyimpan.');
        }

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)->with('status', 'Customer berhasil diperbarui.');
    }

    public function destroy(Request $request, Customer $customer): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('delete', $customer);
        abort_unless($customer->organization_id === $organization->id, 404);
        $customer->delete();

        return redirect()->route('customers.index')->with('status', 'Customer diarsipkan.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'customer_type' => ['required', Rule::in(['business', 'individual'])],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'tax_id' => ['nullable', 'string', 'max:64'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    /** @param array<string, mixed> $validated */
    private function isDuplicate(Organization $organization, array $validated, ?Customer $ignore = null): bool
    {
        return Customer::query()->forOrganization($organization)
            ->when($ignore, fn ($query) => $query->where('id', '!=', $ignore->id))
            ->where(function ($query) use ($validated): void {
                $query->whereRaw('LOWER(name) = ?', [Str::lower((string) $validated['name'])]);
                if (! empty($validated['email'])) {
                    $query->orWhereRaw('LOWER(email) = ?', [Str::lower((string) $validated['email'])]);
                }
            })
            ->exists();
    }

    private function nextCustomerNumber(Organization $organization): string
    {
        $number = $organization->customers()->withTrashed()->count() + 1;

        do {
            $candidate = 'CUS-'.str_pad((string) $number, 6, '0', STR_PAD_LEFT);
            $number++;
        } while ($organization->customers()->withTrashed()->where('customer_number', $candidate)->exists());

        return $candidate;
    }
}
