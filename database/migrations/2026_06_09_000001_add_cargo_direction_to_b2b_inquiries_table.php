<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('b2b_inquiries', function (Blueprint $table) {
            $table->string('cargo_direction', 30)->nullable()->after('service_type'); // 'impor', 'ekspor', 'domestik'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2b_inquiries', function (Blueprint $table) {
            $table->dropColumn('cargo_direction');
        });
    }
};
