<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Service;
use App\Models\WorkOrder;
use App\Services\CurrentOrganization;
use App\Services\InvoiceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
    ) {}

    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [Invoice::class, $organization]);
        $search = trim($request->string('q')->toString());
        $status = InvoiceStatus::tryFrom($request->string('status')->toString());
        $baseQuery = Invoice::query()->forOrganization($organization);

        if ($search !== '') {
            $baseQuery->search($search);
        }

        if ($status !== null) {
            if ($status === InvoiceStatus::Overdue) {
                $baseQuery->where(function (Builder $query): void {
                    $query->where('status', InvoiceStatus::Overdue->value)
                        ->orWhere(function (Builder $open): void {
                            $open->whereIn('status', [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value])
                                ->whereNotNull('due_date')
                                ->whereDate('due_date', '<', now()->toDateString());
                        });
                });
            } else {
                $baseQuery->where('status', $status->value);
            }
        }

        $kpiQuery = clone $baseQuery;
        $kpis = [
            'outstanding' => (int) (clone $kpiQuery)->whereNotIn('status', [InvoiceStatus::Draft->value, InvoiceStatus::Void->value])->sum('amount_due'),
            'overdue' => (int) (clone $kpiQuery)->where(function (Builder $query): void {
                $query->where('status', InvoiceStatus::Overdue->value)
                    ->orWhere(function (Builder $open): void {
                        $open->whereIn('status', [InvoiceStatus::Issued->value, InvoiceStatus::PartiallyPaid->value])
                            ->whereNotNull('due_date')
                            ->whereDate('due_date', '<', now()->toDateString());
                    });
            })->count(),
            'paid_this_month' => (int) Payment::query()->forOrganization($organization)
                ->whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('amount'),
            'drafts' => (int) (clone $kpiQuery)->where('status', InvoiceStatus::Draft->value)->count(),
        ];

        $invoices = $baseQuery
            ->with(['customer', 'workOrder'])
            ->orderByRaw("CASE status WHEN 'overdue' THEN 1 WHEN 'issued' THEN 2 WHEN 'partially_paid' THEN 3 WHEN 'draft' THEN 4 WHEN 'paid' THEN 5 ELSE 6 END")
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $invoices->getCollection()->each(fn (Invoice $invoice): Invoice => $this->invoiceService->refreshStatus($invoice));

        return view('pages.invoices.index', [
            'organization' => $organization,
            'invoices' => $invoices,
            'kpis' => $kpis,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Invoice::class, $organization]);
        $workOrders = WorkOrder::query()
            ->forOrganization($organization)
            ->where('status', WorkOrderStatus::Completed)
            ->whereDoesntHave('invoices', fn (Builder $query): Builder => $query->whereNot('status', InvoiceStatus::Void->value))
            ->with(['customer', 'service'])
            ->orderByDesc('completed_at')
            ->limit(100)
            ->get();
        $selectedWorkOrder = $request->filled('work_order_id')
            ? $workOrders->firstWhere('id', (int) $request->integer('work_order_id'))
            : null;
        $items = $selectedWorkOrder !== null
            ? [$this->defaultItem($selectedWorkOrder)]
            : [['service_id' => null, 'description' => '', 'quantity' => '1.000', 'unit_price' => 0]];

        return view('pages.invoices.form', [
            'organization' => $organization,
            'invoice' => new Invoice(['due_date' => now($organization->timezone)->addDays(14)->toDateString()]),
            'workOrders' => $workOrders,
            'selectedWorkOrder' => $selectedWorkOrder,
            'items' => $items,
            'services' => Service::query()->forOrganization($organization)->where('is_active', true)->orderBy('name')->get(),
            'customers' => Customer::query()->forOrganization($organization)->orderBy('name')->get(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [Invoice::class, $organization]);
        $invoice = $this->invoiceService->createDraft($organization, $request->user(), $this->validated($request, $organization));

        return redirect()->route('invoices.show', $invoice)->with('status', 'Draft invoice berhasil dibuat.');
    }

    public function show(Request $request, Invoice $invoice): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $invoice);
        $invoice = $this->invoiceService->refreshStatus($invoice);
        $invoice->load(['customer', 'workOrder', 'items.service', 'payments.receiver', 'revisionOf']);

        return view('pages.invoices.show', compact('organization', 'invoice'));
    }

    public function edit(Request $request, Invoice $invoice): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $invoice);
        $invoice->load(['customer', 'workOrder', 'items.service']);

        return view('pages.invoices.form', [
            'organization' => $organization,
            'invoice' => $invoice,
            'workOrders' => collect(),
            'selectedWorkOrder' => $invoice->workOrder,
            'items' => $invoice->items->map(fn ($item): array => [
                'service_id' => $item->service_id,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
            ])->all(),
            'services' => Service::query()->forOrganization($organization)->where('is_active', true)->orderBy('name')->get(),
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $invoice);
        $this->invoiceService->updateDraft($invoice, $this->validated($request, $organization));

        return redirect()->route('invoices.show', $invoice)->with('status', 'Draft invoice diperbarui.');
    }

    public function issue(Request $request, Invoice $invoice): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('issue', $invoice);
        $this->invoiceService->issue($invoice);

        return back()->with('status', 'Invoice diterbitkan dan sekarang terkunci.');
    }

    public function void(Request $request, Invoice $invoice): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('void', $invoice);
        $validated = $request->validate(['reason' => ['required', 'string', 'max:2000']]);
        $this->invoiceService->void($invoice, $validated['reason']);

        return back()->with('status', 'Invoice dibatalkan tanpa menghapus riwayat transaksi.');
    }

    public function revise(Request $request, Invoice $invoice): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('revise', $invoice);
        $revision = $this->invoiceService->revise($invoice, $request->user());

        return redirect()->route('invoices.edit', $revision)->with('status', 'Draft revisi dibuat. Invoice lama tetap tersimpan sebagai void.');
    }

    public function storePayment(Request $request, Invoice $invoice): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('recordPayment', $invoice);
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:9223372036854775807'],
            'method' => ['required', Rule::enum(PaymentMethod::class)],
            'reference' => ['nullable', 'string', 'max:120'],
            'paid_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
        $this->invoiceService->recordPayment($invoice, $request->user(), $validated);

        return back()->with('status', 'Pembayaran tercatat dan status invoice diperbarui.');
    }

    public function print(Request $request, Invoice $invoice): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $invoice);
        $invoice = $this->invoiceService->refreshStatus($invoice);
        $invoice->load(['customer', 'workOrder', 'items', 'payments']);

        return view('pages.invoices.print', compact('organization', 'invoice'));
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, Organization $organization): array
    {
        return $request->validate([
            'customer_id' => ['nullable', 'integer', Rule::exists('customers', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'work_order_id' => ['nullable', 'integer', Rule::exists('work_orders', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'due_date' => ['nullable', 'date'],
            'discount_amount' => ['required', 'integer', 'min:0', 'max:9223372036854775807'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where(fn ($query) => $query->where('organization_id', $organization->id))],
            'items.*.description' => ['required', 'string', 'max:180'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.001', 'max:1000000'],
            'items.*.unit_price' => ['required', 'integer', 'min:0', 'max:9223372036854775'],
        ]);
    }

    /** @return array{service_id: int|null, description: string, quantity: string, unit_price: int} */
    private function defaultItem(WorkOrder $workOrder): array
    {
        return [
            'service_id' => $workOrder->service_id,
            'description' => trim(($workOrder->service?->name ? $workOrder->service->name.' · ' : '').$workOrder->title),
            'quantity' => '1.000',
            'unit_price' => $workOrder->estimated_total > 0 ? $workOrder->estimated_total : (int) $workOrder->service?->base_price,
        ];
    }
}
