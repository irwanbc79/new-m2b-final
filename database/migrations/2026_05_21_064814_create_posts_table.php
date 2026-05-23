<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug")->unique();
            $table->text("excerpt")->nullable();
            $table->longText("content");
            $table->string("featured_image")->nullable();
            $table->string("category")->nullable();
            $table->string("tags")->nullable();
            $table->enum("lang", ["id", "en"])->default("id");
            $table->enum("status", ["draft", "published"])->default("draft");
            $table->unsignedBigInteger("wp_id")->nullable();
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
            $table->index(["status", "published_at"]);
        });
    }
    public function down(): void { Schema::dropIfExists("posts"); }
};
