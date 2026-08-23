<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_operations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('client_operation_id');
            $table->string('type', 64);
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->unsignedInteger('base_version')->default(1);
            $table->string('payload_hash', 64);
            $table->json('payload');
            $table->string('state', 24);
            $table->json('response')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'user_id', 'client_operation_id']);
            $table->index(['organization_id', 'user_id', 'state']);
            $table->index(['organization_id', 'work_order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_operations');
    }
};
