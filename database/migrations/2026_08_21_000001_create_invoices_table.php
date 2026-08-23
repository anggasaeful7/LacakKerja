<?php

use App\Enums\InvoiceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('work_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('revision_of_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('number', 32);
            $table->string('status', 24)->default(InvoiceStatus::Draft->value);
            $table->char('currency', 3)->default('IDR');
            $table->dateTime('issued_at')->nullable();
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->unsignedBigInteger('paid_amount')->default(0);
            $table->unsignedBigInteger('amount_due')->default(0);
            $table->text('notes')->nullable();
            $table->dateTime('voided_at')->nullable();
            $table->text('void_reason')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'number']);
            $table->index(['organization_id', 'status', 'due_date']);
            $table->index(['organization_id', 'customer_id', 'created_at']);
            $table->index(['organization_id', 'work_order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
