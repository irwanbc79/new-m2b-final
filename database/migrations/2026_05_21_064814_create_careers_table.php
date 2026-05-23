<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("careers", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("department")->nullable();
            $table->string("location")->default("Jakarta, Indonesia");
            $table->enum("type", ["full-time","part-time","remote","contract"])->default("full-time");
            $table->text("description");
            $table->text("requirements")->nullable();
            $table->text("benefits")->nullable();
            $table->date("deadline")->nullable();
            $table->enum("status", ["open","closed"])->default("open");
            $table->integer("sort_order")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("careers"); }
};
