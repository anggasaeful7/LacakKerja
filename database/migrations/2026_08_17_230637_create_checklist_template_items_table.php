<?php

use App\Enums\ChecklistInputType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_template_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->default(1);
            $table->string('label');
            $table->string('input_type', 24)->default(ChecklistInputType::Checkbox->value);
            $table->boolean('is_required')->default(false);
            $table->boolean('photo_required')->default(false);
            $table->json('options')->nullable();
            $table->string('help_text')->nullable();
            $table->timestamps();

            $table->unique(['checklist_template_id', 'position']);
            $table->index(['checklist_template_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_template_items');
    }
};
