<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mora_leads', function (Blueprint $table) {
            $table->string('service_interest', 30)->nullable()->after('source');
            $table->decimal('estimated_value', 15, 2)->nullable()->after('service_interest');
            $table->text('notes')->nullable()->after('estimated_value');
            $table->timestamp('follow_up_at')->nullable()->after('notes');
            $table->timestamp('followed_up_at')->nullable()->after('follow_up_at');
        });
    }

    public function down(): void
    {
        Schema::table('mora_leads', function (Blueprint $table) {
            $table->dropColumn(['service_interest', 'estimated_value', 'notes', 'follow_up_at', 'followed_up_at']);
        });
    }
};
