<?php

use App\Enums\AttachmentCategory;
use App\Enums\AttachmentUploadStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('category', 24)->default(AttachmentCategory::Evidence->value);
            $table->string('disk', 32)->default('local');
            $table->string('path', 500);
            $table->string('original_name', 255);
            $table->string('mime_type', 120);
            $table->unsignedBigInteger('size_bytes');
            $table->string('checksum', 128)->nullable();
            $table->string('upload_status', 24)->default(AttachmentUploadStatus::Completed->value);
            $table->boolean('is_required')->default(false);
            $table->timestamps();

            $table->index(['work_order_id', 'category']);
            $table->index(['work_order_id', 'upload_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
