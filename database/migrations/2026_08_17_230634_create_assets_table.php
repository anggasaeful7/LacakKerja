<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_site_id')->constrained('customer_sites')->cascadeOnDelete();
            $table->string('asset_identifier', 40);
            $table->string('qr_identifier', 64)->unique();
            $table->string('name');
            $table->string('category', 80);
            $table->string('brand', 80)->nullable();
            $table->string('model', 80)->nullable();
            $table->string('serial_number', 120)->nullable();
            $table->string('status', 24)->default('active');
            $table->date('installation_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'asset_identifier']);
            $table->unique(['organization_id', 'serial_number']);
            $table->index(['organization_id', 'customer_site_id']);
            $table->index(['organization_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
