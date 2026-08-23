<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_order_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('completed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('sort_order')->default(1);
            $table->string('label');
            $table->string('input_type', 24);
            $table->boolean('is_required')->default(false);
            $table->boolean('photo_required')->default(false);
            $table->json('options')->nullable();
            $table->json('value')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->index(['work_order_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_checklist_items');
    }
};
