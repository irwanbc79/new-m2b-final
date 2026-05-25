<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\MoraChatController;

Route::get("/", [PageController::class, "home"])->name("home");
Route::get("/tentang-kami", [PageController::class, "about"])->name("about");
Route::get("/tim", [PageController::class, "tim"])->name("tim");

Route::get("/blog", [BlogController::class, "index"])->name("blog.index");
Route::get("/blog/{slug}", [BlogController::class, "show"])->name("blog.show");

Route::get("/karir", [CareerController::class, "index"])->name("karir.index");
Route::get("/karir/{id}", [CareerController::class, "show"])->name("karir.show");

Route::get("/privacy-policy", [PageController::class, "privacy"])->name("privacy");
Route::get("/disclaimer", [PageController::class, "disclaimer"])->name("disclaimer");
Route::get("/ketentuan-layanan", [PageController::class, "terms"])->name("terms");

Route::middleware('throttle:30,1')->group(function () {
    Route::post("/mora/chat", [MoraChatController::class, "chat"])->name("mora.chat");
    Route::post("/mora/lead", [MoraChatController::class, "lead"])->name("mora.lead");
});
