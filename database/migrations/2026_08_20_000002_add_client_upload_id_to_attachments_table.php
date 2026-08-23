<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attachments', function (Blueprint $table): void {
            $table->uuid('client_upload_id')->nullable()->after('work_order_id');
            $table->unique(['work_order_id', 'client_upload_id']);
        });
    }

    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table): void {
            $table->dropUnique('attachments_work_order_id_client_upload_id_unique');
            $table->dropColumn('client_upload_id');
        });
    }
};
