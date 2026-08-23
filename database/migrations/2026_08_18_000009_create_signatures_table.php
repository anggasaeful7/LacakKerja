<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->string('signer_name', 160);
            $table->string('path', 500);
            $table->string('consent_version', 32);
            $table->dateTime('signed_at');
            $table->timestamps();

            $table->unique('work_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
