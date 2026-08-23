<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technician_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('employee_code', 64)->nullable();
            $table->string('phone', 40)->nullable();
            $table->json('skills')->nullable();
            $table->string('display_color', 16)->default('#0284c7');
            $table->json('availability')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'user_id']);
            $table->unique(['organization_id', 'employee_code']);
            $table->index(['organization_id', 'display_color']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technician_profiles');
    }
};
