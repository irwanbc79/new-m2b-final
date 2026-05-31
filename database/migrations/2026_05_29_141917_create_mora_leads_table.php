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
        Schema::create('mora_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('company', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20);
            $table->boolean('emailed')->default(false); // was the notification email sent OK?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mora_leads');
    }
};
