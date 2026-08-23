<?php

namespace Database\Seeders;

use App\Enums\AssetStatus;
use App\Enums\ChecklistInputType;
use App\Enums\ChecklistStatus;
use App\Enums\InvoiceStatus;
use App\Enums\MembershipStatus;
use App\Enums\OrganizationRole;
use App\Enums\PaymentMethod;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Asset;
use App\Models\ChecklistTemplate;
use App\Models\Customer;
use App\Models\CustomerSite;
use App\Models\Invoice;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Service;
use App\Models\TechnicianProfile;
use App\Models\TimeLog;
use App\Models\User;
use App\Models\WorkOrder;
use App\Services\WorkOrderService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DemoSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $organization = Organization::firstOrCreate(
            ['slug' => (string) config('demo.organization_slug', 'lacakkerja-demo')],
            [
                'name' => 'LacakKerja Demo',
                'timezone' => 'Asia/Jakarta',
                'currency' => 'IDR',
                'settings' => ['week_starts_on' => 1, 'date_format' => 'd M Y', 'signature_required' => true],
            ],
        );

        $this->guardDemoUserScope($organization);

        $owner = User::updateOrCreate(
            ['email' => 'owner@lacakkerja.test'],
            ['name' => 'Dimas Owner', 'password' => Hash::make($this->demoPassword()), 'email_verified_at' => now()],
        );

        $this->ensureMembership($organization, $owner, OrganizationRole::Owner);
        $owner->forceFill(['current_organization_id' => $organization->id, 'email_verified_at' => now()])->saveQuietly();

        $dispatcher = User::updateOrCreate(
            ['email' => 'dispatcher@lacakkerja.test'],
            ['name' => 'Nadia Dispatcher', 'password' => Hash::make($this->demoPassword()), 'email_verified_at' => now()],
        );
        $this->ensureMembership($organization, $dispatcher, OrganizationRole::Dispatcher);
        $dispatcher->forceFill(['current_organization_id' => $organization->id, 'email_verified_at' => now()])->saveQuietly();

        foreach (['Raka Teknisi', 'Sari Teknisi', 'Bimo Teknisi', 'Ayu Teknisi'] as $index => $name) {
            $technician = User::updateOrCreate(
                ['email' => 'technician'.($index + 1).'@lacakkerja.test'],
                ['name' => $name, 'password' => Hash::make($this->demoPassword()), 'email_verified_at' => now()],
            );
            $this->ensureMembership($organization, $technician, OrganizationRole::Technician);
            $technician->forceFill(['current_organization_id' => $organization->id, 'email_verified_at' => now()])->saveQuietly();
            TechnicianProfile::updateOrCreate(
                ['organization_id' => $organization->id, 'user_id' => $technician->id],
                [
                    'employee_code' => 'TECH-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'phone' => '+62 811 0000 '.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'skills' => [['HVAC', 'Electrical'], ['HVAC', 'Plumbing'], ['Electrical', 'Generator'], ['HVAC', 'Generator']][$index],
                    'display_color' => ['#0284c7', '#7c3aed', '#059669', '#d97706'][$index],
                    'availability' => ['mon' => ['start' => '08:00', 'end' => '17:00'], 'tue' => ['start' => '08:00', 'end' => '17:00'], 'wed' => ['start' => '08:00', 'end' => '17:00'], 'thu' => ['start' => '08:00', 'end' => '17:00'], 'fri' => ['start' => '08:00', 'end' => '17:00']],
                ],
            );
        }
        $this->seedMasterData($organization);
        $this->seedWorkOrders($organization);
        $this->seedInvoices($organization);
    }

    private function seedMasterData(Organization $organization): void
    {
        $arunika = Customer::updateOrCreate(
            ['organization_id' => $organization->id, 'customer_number' => 'CUS-000001'],
            ['name' => 'PT Arunika Facility', 'customer_type' => 'business', 'email' => 'facility@arunika.test', 'phone' => '+62 21 555 0101', 'notes' => 'Pelanggan prioritas untuk preventive maintenance.'],
        );
        $arunikaSite = CustomerSite::updateOrCreate(
            ['organization_id' => $organization->id, 'customer_id' => $arunika->id, 'code' => 'SITE-JKT-01'],
            ['name' => 'Gedung Arunika Sudirman', 'address_line1' => 'Jl. Jenderal Sudirman Kav. 10', 'city' => 'Jakarta Selatan', 'province' => 'DKI Jakarta', 'postal_code' => '10220', 'contact_name' => 'Fajar Pratama', 'contact_phone' => '+62 811 2222 3333', 'latitude' => -6.2088, 'longitude' => 106.8228, 'access_notes' => 'Lapor ke security lobby dan bawa kartu identitas.', 'is_default' => true],
        );
        Asset::updateOrCreate(
            ['organization_id' => $organization->id, 'asset_identifier' => 'AST-000001'],
            ['customer_id' => $arunika->id, 'customer_site_id' => $arunikaSite->id, 'qr_identifier' => 'LK-QR-ARUNIKA1', 'name' => 'AHU Lantai 12', 'category' => 'Air Handling Unit', 'brand' => 'Daikin', 'model' => 'FXMQ125', 'serial_number' => 'SN-ARU-1201', 'status' => AssetStatus::Active, 'installation_date' => '2024-02-10'],
        );
        $bumi = Customer::updateOrCreate(
            ['organization_id' => $organization->id, 'customer_number' => 'CUS-000002'],
            ['name' => 'Bumi Residence', 'customer_type' => 'business', 'email' => 'engineering@bumiresidence.test', 'phone' => '+62 21 555 0202'],
        );
        $bumiSite = CustomerSite::updateOrCreate(
            ['organization_id' => $organization->id, 'customer_id' => $bumi->id, 'code' => 'SITE-BGR-01'],
            ['name' => 'Bumi Residence Tower A', 'address_line1' => 'Jl. Pajajaran No. 88', 'city' => 'Bogor', 'province' => 'Jawa Barat', 'postal_code' => '16143', 'contact_name' => 'Dewi Lestari', 'contact_phone' => '+62 812 4444 5555', 'latitude' => -6.5950, 'longitude' => 106.8166, 'is_default' => true],
        );
        Asset::updateOrCreate(
            ['organization_id' => $organization->id, 'asset_identifier' => 'AST-000002'],
            ['customer_id' => $bumi->id, 'customer_site_id' => $bumiSite->id, 'qr_identifier' => 'LK-QR-BUMIRES01', 'name' => 'Chiller Utama', 'category' => 'Chiller', 'brand' => 'Trane', 'model' => 'CGAM 060', 'serial_number' => 'SN-BUMI-0101', 'status' => AssetStatus::Active, 'installation_date' => '2023-08-14'],
        );
        $preventive = Service::updateOrCreate(
            ['organization_id' => $organization->id, 'service_code' => 'SVC-0001'],
            ['name' => 'Preventive Maintenance AC', 'description' => 'Pemeriksaan dan pembersihan berkala unit AC.', 'duration_minutes' => 120, 'base_price' => 850000, 'is_active' => true],
        );
        Service::updateOrCreate(
            ['organization_id' => $organization->id, 'service_code' => 'SVC-0002'],
            ['name' => 'Emergency Repair', 'description' => 'Penanganan kerusakan yang membutuhkan respons cepat.', 'duration_minutes' => 180, 'base_price' => 1250000, 'is_active' => true],
        );
        $checklist = ChecklistTemplate::updateOrCreate(
            ['organization_id' => $organization->id, 'template_key' => 'ac.preventive', 'version' => 1],
            ['service_id' => $preventive->id, 'name' => 'Checklist Preventive Maintenance AC', 'description' => 'Standar pemeriksaan preventive untuk teknisi lapangan.', 'status' => ChecklistStatus::Published, 'is_current' => true, 'published_at' => now()],
        );
        if ($checklist->items()->count() === 0) {
            $checklist->items()->createMany([
                ['position' => 1, 'label' => 'Kondisi filter dan evaporator bersih', 'input_type' => ChecklistInputType::Checkbox, 'is_required' => true, 'photo_required' => true],
                ['position' => 2, 'label' => 'Suhu supply air (°C)', 'input_type' => ChecklistInputType::Number, 'is_required' => true, 'photo_required' => false],
                ['position' => 3, 'label' => 'Catatan teknisi', 'input_type' => ChecklistInputType::Text, 'is_required' => false, 'photo_required' => false],
            ]);
            $checklist->refresh()->load('items');
            $checklist->publishSnapshot();
        }
    }

    private function seedWorkOrders(Organization $organization): void
    {
        $customers = $organization->customers()->with(['sites', 'assets'])->orderBy('id')->get();
        $services = $organization->services()->orderBy('id')->get();
        $technicians = $organization->memberships()
            ->with('user')
            ->where('status', MembershipStatus::Active)
            ->where('role', OrganizationRole::Technician)
            ->get()
            ->values();

        if ($customers->isEmpty() || $services->isEmpty() || $technicians->isEmpty()) {
            return;
        }

        $definitions = [
            ['number' => 'WO-2026-000101', 'customer' => 0, 'status' => WorkOrderStatus::Draft, 'priority' => WorkOrderPriority::Normal, 'title' => 'Permintaan pemeriksaan AC lobby', 'start' => null, 'end' => null, 'sla' => now()->addDays(2)],
            ['number' => 'WO-2026-000102', 'customer' => 0, 'status' => WorkOrderStatus::Scheduled, 'priority' => WorkOrderPriority::High, 'title' => 'Preventive maintenance AHU lantai 12', 'start' => now()->addDay()->setTime(9, 0), 'end' => now()->addDay()->setTime(11, 0), 'sla' => now()->addDay()->setTime(17, 0)],
            ['number' => 'WO-2026-000103', 'customer' => 1, 'status' => WorkOrderStatus::Dispatched, 'priority' => WorkOrderPriority::Urgent, 'title' => 'Emergency repair chiller utama', 'start' => now()->setTime(10, 0), 'end' => now()->setTime(13, 0), 'sla' => now()->subHour()],
            ['number' => 'WO-2026-000104', 'customer' => 0, 'status' => WorkOrderStatus::EnRoute, 'priority' => WorkOrderPriority::High, 'title' => 'Pemeriksaan unit outdoor', 'start' => now()->setTime(13, 0), 'end' => now()->setTime(15, 0), 'sla' => now()->addHours(3)],
            ['number' => 'WO-2026-000105', 'customer' => 1, 'status' => WorkOrderStatus::InProgress, 'priority' => WorkOrderPriority::Normal, 'title' => 'Penggantian filter dan pengecekan tekanan', 'start' => now()->subHour(), 'end' => now()->addHour(), 'sla' => now()->addHours(2)],
            ['number' => 'WO-2026-000106', 'customer' => 0, 'status' => WorkOrderStatus::Completed, 'priority' => WorkOrderPriority::Normal, 'title' => 'Preventive maintenance selesai', 'start' => now()->subDays(2)->setTime(9, 0), 'end' => now()->subDays(2)->setTime(11, 0), 'sla' => now()->subDays(2)->setTime(17, 0)],
            ['number' => 'WO-2026-000107', 'customer' => 1, 'status' => WorkOrderStatus::Cancelled, 'priority' => WorkOrderPriority::Low, 'title' => 'Pekerjaan dibatalkan pelanggan', 'start' => now()->subDay(), 'end' => now()->subDay()->addHours(2), 'sla' => now()->subDay()],
        ];

        foreach ($definitions as $index => $definition) {
            $customer = $customers[$definition['customer']] ?? $customers->first();
            $site = $customer->sites->first();
            $asset = $customer->assets->first();
            $technician = $technicians[$index % $technicians->count()]->user;

            $workOrder = WorkOrder::updateOrCreate(
                ['organization_id' => $organization->id, 'number' => $definition['number']],
                [
                    'customer_id' => $customer->id,
                    'customer_site_id' => $site?->id,
                    'asset_id' => $asset?->id,
                    'service_id' => $services->first()->id,
                    'created_by' => $organization->memberships()->where('role', OrganizationRole::Dispatcher)->value('user_id'),
                    'title' => $definition['title'],
                    'description' => 'Demo work order untuk memperlihatkan alur operasional LacakKerja.',
                    'priority' => $definition['priority'],
                    'status' => $definition['status'],
                    'scheduled_start' => $definition['start'],
                    'scheduled_end' => $definition['end'],
                    'sla_due_at' => $definition['sla'],
                    'completed_at' => $definition['status'] === WorkOrderStatus::Completed ? now()->subDays(2)->setTime(11, 30) : null,
                    'estimated_total' => $services->first()->base_price,
                    'lock_version' => 1,
                ],
            );

            $workOrder->assignments()->updateOrCreate(
                ['user_id' => $technician->id],
                ['is_primary' => true, 'assigned_at' => $definition['start'] ?? now()],
            );

            if ($workOrder->checklistItems()->count() === 0) {
                app(WorkOrderService::class)->snapshotChecklist($workOrder);
            }

            if ($workOrder->statusHistories()->count() === 0) {
                $workOrder->statusHistories()->create([
                    'changed_by' => $technician->id,
                    'from_status' => null,
                    'to_status' => $definition['status'],
                    'reason' => 'Seed demo.',
                    'created_at' => now(),
                ]);
            }

            if ($definition['status'] === WorkOrderStatus::Completed) {
                $workOrder->notes()->firstOrCreate(
                    ['body' => 'Pekerjaan selesai dan unit sudah diuji bersama pelanggan.'],
                    ['user_id' => $technician->id, 'visibility' => 'customer'],
                );
                $workOrder->checklistItems()->where('is_required', true)->get()->each(function ($item) use ($technician): void {
                    $item->update(['value' => ['value' => true], 'completed_by' => $technician->id, 'completed_at' => now()]);
                });
                TimeLog::firstOrCreate(
                    ['work_order_id' => $workOrder->id, 'user_id' => $technician->id],
                    ['started_at' => now()->subDays(2)->setTime(9, 0), 'ended_at' => now()->subDays(2)->setTime(11, 0), 'duration_minutes' => 120],
                );
            }
        }
    }

    private function seedInvoices(Organization $organization): void
    {
        $customers = $organization->customers()->orderBy('id')->get();
        if ($customers->isEmpty()) {
            return;
        }

        $completedWorkOrder = $organization->workOrders()->where('number', 'WO-2026-000106')->first();
        $definitions = [
            ['number' => 'INV-2026-000101', 'customer_id' => $customers[0]->id, 'work_order_id' => $completedWorkOrder?->id, 'status' => InvoiceStatus::Paid, 'total' => 850000, 'paid' => 850000, 'due' => now()->subDays(4)->toDateString(), 'reference' => 'BCA-ARUNIKA-0101'],
            ['number' => 'INV-2026-000102', 'customer_id' => $customers[1]->id ?? $customers[0]->id, 'work_order_id' => null, 'status' => InvoiceStatus::PartiallyPaid, 'total' => 1250000, 'paid' => 500000, 'due' => now()->addDays(7)->toDateString(), 'reference' => 'MANDIRI-BUMI-0102'],
            ['number' => 'INV-2026-000103', 'customer_id' => $customers[0]->id, 'work_order_id' => null, 'status' => InvoiceStatus::Issued, 'total' => 640000, 'paid' => 0, 'due' => now()->addDays(14)->toDateString(), 'reference' => null],
            ['number' => 'INV-2026-000104', 'customer_id' => $customers[1]->id ?? $customers[0]->id, 'work_order_id' => null, 'status' => InvoiceStatus::Overdue, 'total' => 980000, 'paid' => 0, 'due' => now()->subDays(12)->toDateString(), 'reference' => null],
        ];

        foreach ($definitions as $definition) {
            $invoice = Invoice::updateOrCreate(
                ['organization_id' => $organization->id, 'number' => $definition['number']],
                [
                    'customer_id' => $definition['customer_id'],
                    'work_order_id' => $definition['work_order_id'],
                    'status' => $definition['status'],
                    'currency' => $organization->currency,
                    'issued_at' => now()->subDays(10),
                    'due_date' => $definition['due'],
                    'subtotal' => $definition['total'],
                    'discount_amount' => 0,
                    'tax_rate' => '0.00',
                    'tax_amount' => 0,
                    'total_amount' => $definition['total'],
                    'paid_amount' => $definition['paid'],
                    'amount_due' => $definition['total'] - $definition['paid'],
                    'notes' => 'Invoice demo untuk portfolio LacakKerja.',
                ],
            );
            $invoice->items()->firstOrCreate(
                ['description' => 'Layanan field service'],
                ['quantity' => '1.000', 'unit_price' => $definition['total'], 'line_total' => $definition['total']],
            );

            if ($definition['paid'] > 0 && filled($definition['reference'])) {
                Payment::firstOrCreate(
                    ['invoice_id' => $invoice->id, 'reference' => $definition['reference']],
                    ['organization_id' => $organization->id, 'received_by' => null, 'amount' => $definition['paid'], 'method' => PaymentMethod::BankTransfer, 'paid_at' => now()->subDays(3), 'notes' => 'Seed demo payment.'],
                );
            }
        }
    }

    private function guardDemoUserScope(Organization $organization): void
    {
        $conflictingEmails = User::query()
            ->whereIn('email', config('demo.emails', []))
            ->whereHas('memberships', fn ($query) => $query->where('organization_id', '!=', $organization->id))
            ->pluck('email')
            ->all();

        if ($conflictingEmails !== []) {
            throw new RuntimeException('Demo emails belong to another organization: '.implode(', ', $conflictingEmails));
        }
    }

    private function demoPassword(): string
    {
        $password = config('demo.password');

        if (! is_string($password) || strlen($password) < 12) {
            throw new RuntimeException('Set DEMO_PASSWORD to a value with at least 12 characters before seeding demo data.');
        }

        return $password;
    }

    private function ensureMembership(Organization $organization, User $user, OrganizationRole $role): void
    {
        Membership::updateOrCreate(
            ['organization_id' => $organization->id, 'user_id' => $user->id],
            [
                'role' => $role,
                'status' => MembershipStatus::Active,
                'joined_at' => now(),
            ],
        );
    }
}
