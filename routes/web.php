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

// Fallback: tangkap URL WordPress lama dan redirect 301 ke Laravel
Route::fallback(function () {
    $path = request()->path();

    // Handle /?p=ID — WP static page IDs
    if (request()->has('p')) {
        $wpIdMap = [
            624 => '/privacy-policy',
            631 => '/disclaimer',
            638 => '/ketentuan-layanan',
        ];
        $p = (int) request()->get('p');
        if (isset($wpIdMap[$p])) {
            return redirect()->to($wpIdMap[$p], 301);
        }
    }

    // Handle /%postname%/ dan /%category%/%postname%/ WP permalink formats
    $slug = basename($path);
    $post = cache()->remember("wp_redirect_{$slug}", 3600, fn () =>
        \App\Models\Post::where('slug', $slug)->orWhere('slug', $path)->first()
    );
    if ($post) {
        return redirect()->to("/blog/{$post->slug}", 301);
    }

    abort(404);
});
