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
        Schema::create('b2b_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('company', 100);
            $table->string('npwp', 50);
            $table->string('email', 100);
            $table->string('phone', 30);
            $table->string('service_type', 20); // 'paid' or 'free_ship'
            $table->string('shipment_type', 30); // 'Sea FCL', 'Sea LCL', 'Air'
            $table->string('volume', 100);
            $table->string('route_origin', 100)->nullable();
            $table->string('route_destination', 100)->nullable();
            $table->string('est_shipment_date', 100)->nullable();
            $table->text('files')->nullable(); // JSON array of stored file info
            $table->string('invoice_no', 50)->nullable();
            $table->string('status', 30)->default('pending'); // 'pending', 'paid', 'processing'
            $table->boolean('emailed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2b_inquiries');
    }
};
