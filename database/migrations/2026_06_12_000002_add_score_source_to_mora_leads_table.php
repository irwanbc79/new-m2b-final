<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mora_leads', function (Blueprint $table) {
            $table->string('score', 10)->default('cold')->after('summary');
            $table->string('source', 20)->default('mora_chat')->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('mora_leads', function (Blueprint $table) {
            $table->dropColumn(['score', 'source']);
        });
    }
};
