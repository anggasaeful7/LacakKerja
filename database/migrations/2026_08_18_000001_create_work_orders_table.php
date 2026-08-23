<?php

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('customer_site_id')->constrained('customer_sites')->restrictOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('number', 32);
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->string('priority', 24)->default(WorkOrderPriority::Normal->value);
            $table->string('status', 24)->default(WorkOrderStatus::Draft->value);
            $table->dateTime('scheduled_start')->nullable();
            $table->dateTime('scheduled_end')->nullable();
            $table->dateTime('sla_due_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->unsignedBigInteger('estimated_total')->default(0);
            $table->unsignedInteger('lock_version')->default(1);
            $table->timestamps();

            $table->unique(['organization_id', 'number']);
            $table->index(['organization_id', 'status', 'scheduled_start']);
            $table->index(['organization_id', 'priority', 'sla_due_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
