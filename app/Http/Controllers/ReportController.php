<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Membership;
use App\Models\Organization;
use App\Services\CurrentOrganization;
use App\Services\OperationsReportQuery;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct(
        private readonly OperationsReportQuery $reportQuery,
    ) {}

    public function operations(Request $request): View|Response
    {
        $organization = app(CurrentOrganization::class)->require($request->user());

        if (! $this->canView($request, $organization)) {
            return $this->noPermission($organization);
        }

        $filters = $this->filters($request, $organization, false);
        $workOrders = $this->reportQuery->workOrders($organization, $filters)->orderByDesc('created_at')->paginate(25)->withQueryString();

        return view('pages.reports.operations', [
            'organization' => $organization,
            'filters' => $filters,
            'summary' => $this->reportQuery->workOrderSummary($organization, $filters),
            'workOrders' => $workOrders,
            'technicians' => $this->technicians($organization),
        ]);
    }

    public function exportOperations(Request $request): Response|StreamedResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());

        if (! $this->canView($request, $organization)) {
            return $this->noPermission($organization);
        }

        $filters = $this->filters($request, $organization, false);
        $query = $this->reportQuery->workOrders($organization, $filters)->orderBy('id');

        return response()->streamDownload(function () use ($query, $organization): void {
            $handle = fopen('php://output', 'wb');
            if ($handle === false) {
                throw new RuntimeException('CSV output stream could not be opened.');
            }
            fputcsv($handle, ['Nomor', 'Judul', 'Pelanggan', 'Teknisi', 'Status', 'Prioritas', 'Jadwal', 'SLA', 'Estimasi']);

            foreach ($query->cursor() as $workOrder) {
                $scheduledAt = $workOrder->scheduled_start;
                $slaDueAt = $workOrder->sla_due_at;
                $technicianName = $workOrder->primaryAssignment === null ? 'Belum ditugaskan' : $workOrder->primaryAssignment->user->name;
                fputcsv($handle, [
                    $this->csv($workOrder->number),
                    $this->csv($workOrder->title),
                    $this->csv($workOrder->customer->name),
                    $this->csv($technicianName),
                    $this->csv($workOrder->status->label()),
                    $this->csv($workOrder->priority->label()),
                    $this->csv($scheduledAt instanceof CarbonImmutable ? $scheduledAt->format('d M Y H:i') : '—'),
                    $this->csv($slaDueAt instanceof CarbonImmutable ? $slaDueAt->format('d M Y H:i') : '—'),
                    $this->csv($this->money((int) $workOrder->estimated_total, $organization->currency)),
                ]);
            }

            fclose($handle);
        }, 'lacakkerja-operations-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function revenue(Request $request): View|Response
    {
        $organization = app(CurrentOrganization::class)->require($request->user());

        if (! $this->canView($request, $organization)) {
            return $this->noPermission($organization);
        }

        $filters = $this->filters($request, $organization, true);
        $invoices = $this->reportQuery->invoices($organization, $filters)->orderByDesc('created_at')->paginate(25)->withQueryString();

        return view('pages.reports.revenue', [
            'organization' => $organization,
            'filters' => $filters,
            'summary' => $this->reportQuery->invoiceSummary($organization, $filters),
            'invoices' => $invoices,
        ]);
    }

    public function exportRevenue(Request $request): Response|StreamedResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());

        if (! $this->canView($request, $organization)) {
            return $this->noPermission($organization);
        }

        $filters = $this->filters($request, $organization, true);
        $query = $this->reportQuery->invoices($organization, $filters)->orderBy('id');

        return response()->streamDownload(function () use ($query, $organization): void {
            $handle = fopen('php://output', 'wb');
            if ($handle === false) {
                throw new RuntimeException('CSV output stream could not be opened.');
            }
            fputcsv($handle, ['Nomor', 'Pelanggan', 'Work order', 'Status', 'Terbit', 'Jatuh tempo', 'Total', 'Dibayar', 'Sisa']);

            foreach ($query->cursor() as $invoice) {
                $issuedAt = $invoice->issued_at;
                $dueDate = $invoice->due_date;
                fputcsv($handle, [
                    $this->csv($invoice->number),
                    $this->csv($invoice->customer->name),
                    $this->csv($invoice->workOrder === null ? '—' : $invoice->workOrder->number),
                    $this->csv($invoice->status->label()),
                    $this->csv($issuedAt instanceof CarbonImmutable ? $issuedAt->format('d M Y') : '—'),
                    $this->csv($dueDate instanceof CarbonImmutable ? $dueDate->format('d M Y') : '—'),
                    $this->csv($this->money((int) $invoice->total_amount, $organization->currency)),
                    $this->csv($this->money((int) $invoice->paid_amount, $organization->currency)),
                    $this->csv($this->money((int) $invoice->amount_due, $organization->currency)),
                ]);
            }

            fclose($handle);
        }, 'lacakkerja-revenue-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** @return array{from: CarbonImmutable, to: CarbonImmutable, status?: string|null, priority?: string|null, technician_id?: int|null} */
    private function filters(Request $request, Organization $organization, bool $revenue): array
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', 'string', 'max:32'],
            'priority' => ['nullable', Rule::enum(WorkOrderPriority::class)],
            'technician_id' => ['nullable', 'integer'],
        ]);
        $timezone = $organization->timezone;
        $from = CarbonImmutable::createFromFormat('Y-m-d', (string) ($validated['from'] ?? now($timezone)->subDays(29)->toDateString()), $timezone)->startOfDay();
        $to = CarbonImmutable::createFromFormat('Y-m-d', (string) ($validated['to'] ?? now($timezone)->toDateString()), $timezone)->endOfDay();

        if ($to->lessThan($from)) {
            [$from, $to] = [$to->startOfDay(), $from->endOfDay()];
        }

        $filters = [
            'from' => $from,
            'to' => $to,
            'status' => $revenue ? InvoiceStatus::tryFrom((string) ($validated['status'] ?? ''))?->value : WorkOrderStatus::tryFrom((string) ($validated['status'] ?? ''))?->value,
            'priority' => $revenue ? null : (isset($validated['priority']) ? WorkOrderPriority::tryFrom((string) $validated['priority'])?->value : null),
            'technician_id' => null,
        ];

        if (! $revenue && isset($validated['technician_id'])) {
            $technicianId = (int) $validated['technician_id'];
            $filters['technician_id'] = Membership::query()->forOrganization($organization)->where('user_id', $technicianId)->where('role', OrganizationRole::Technician->value)->where('status', MembershipStatus::Active->value)->exists() ? $technicianId : null;
        }

        return $filters;
    }

    private function canView(Request $request, Organization $organization): bool
    {
        return $request->user()->membershipFor($organization)?->role->canManageMasterData() ?? false;
    }

    private function noPermission(Organization $organization): Response
    {
        return response()->view('pages.reports.no-permission', compact('organization'), 403);
    }

    /** @return array<int, Membership> */
    private function technicians(Organization $organization): array
    {
        return Membership::query()->forOrganization($organization)->where('role', OrganizationRole::Technician->value)->where('status', MembershipStatus::Active->value)->with('user:id,name')->orderBy('id')->get()->all();
    }

    private function csv(mixed $value): string
    {
        $text = (string) ($value ?? '');

        return preg_match('/^[=+\-@]/', $text) === 1 ? "'{$text}" : $text;
    }

    private function money(int $amount, string $currency): string
    {
        $locale = str_contains(app()->getLocale(), '_') ? app()->getLocale() : app()->getLocale().'_ID';
        $formatted = class_exists(\NumberFormatter::class) ? (new \NumberFormatter($locale, \NumberFormatter::DECIMAL))->format($amount) : number_format($amount, 0, ',', '.');

        return $currency.' '.($formatted ?: '0');
    }
}
