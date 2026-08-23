<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->dateTime('assigned_at')->useCurrent();
            $table->dateTime('acknowledged_at')->nullable();
            $table->timestamps();

            $table->unique(['work_order_id', 'user_id']);
            $table->index(['user_id', 'assigned_at']);
            $table->index(['work_order_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_assignments');
    }
};
