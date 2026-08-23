<?php

use App\Enums\ChecklistStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('template_key', 80);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->string('status', 24)->default(ChecklistStatus::Draft->value);
            $table->boolean('is_current')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->json('snapshot')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'template_key', 'version']);
            $table->index(['organization_id', 'template_key', 'is_current']);
            $table->index(['organization_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_templates');
    }
};
