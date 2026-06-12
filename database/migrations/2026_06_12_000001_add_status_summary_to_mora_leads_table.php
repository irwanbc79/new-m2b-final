<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mora_leads', function (Blueprint $table) {
            $table->string('status', 20)->default('new')->after('chat_history');
            $table->text('summary')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('mora_leads', function (Blueprint $table) {
            $table->dropColumn(['status', 'summary']);
        });
    }
};
