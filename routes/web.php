<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\MoraChatController;
use App\Http\Controllers\B2bInquiryController;
use App\Http\Middleware\PublicPageCache;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

Route::get("/", [PageController::class, "home"])->name("home");
Route::get("/tentang-kami", [PageController::class, "about"])->name("about");
Route::get("/tim", [PageController::class, "tim"])->name("tim");

/**
 * Halaman GET publik blog tanpa session: HTML-nya boleh di-cache CDN
 * (lihat App\Http\Middleware\PublicPageCache).
 *
 * Ketiga middleware dilepas karena semuanya menulis cookie/session:
 *  - StartSession           → Set-Cookie session di setiap response,
 *  - ShareErrorsFromSession → butuh session milik request,
 *  - ValidateCsrfToken      → menambah cookie XSRF-TOKEN di setiap GET.
 * Semuanya tidak relevan untuk GET publik yang tidak punya input pengguna.
 *
 * Konsekuensi yang WAJIB dijaga: route di bawah ini tidak boleh bergantung pada
 * session — tidak ada @csrf, tidak ada flash message, dan error validasi server
 * tidak dirender. Token CSRF untuk form MORA/B2B di layout diambil on-demand
 * dari GET /csrf-token (lihat window.m2bCsrfToken() di layouts/app.blade.php).
 */
$anonymousPage = fn ($route) => $route
    ->withoutMiddleware([
        StartSession::class,
        ShareErrorsFromSession::class,
        ValidateCsrfToken::class,
    ])
    ->middleware(PublicPageCache::class);

$anonymousPage(Route::get("/blog", [BlogController::class, "index"]))->name("blog.index");
$anonymousPage(Route::get("/blog/feed", [BlogController::class, "feed"]))->name("blog.feed");
$anonymousPage(Route::get("/blog/kalkulator-bea-masuk", [BlogController::class, "kalkulator"]))->name("blog.kalkulator"); // must precede /blog/{slug}
$anonymousPage(Route::get("/blog/{slug}", [BlogController::class, "show"]))->name("blog.show");

// Token CSRF untuk form MORA/B2B di halaman yang di-cache CDN (HTML-nya tidak
// boleh memuat token karena tidak punya session). Route ini SENGAJA tanpa
// $anonymousPage supaya tetap punya session — token harus sepasang dengan
// session yang dipakai endpoint POST /mora/chat, /mora/lead, dan /b2b/inquiry.
Route::get("/csrf-token", fn () => response()
    ->json(["token" => csrf_token()])
    ->header("Cache-Control", "no-store, max-age=0, must-revalidate")
    ->header("X-Robots-Tag", "noindex, nofollow"))
    ->name("csrf.token");

Route::get("/karir", [CareerController::class, "index"])->name("karir.index");
Route::get("/karir/{id}", [CareerController::class, "show"])->name("karir.show");

Route::get("/privacy-policy", [PageController::class, "privacy"])->name("privacy");
Route::get("/disclaimer", [PageController::class, "disclaimer"])->name("disclaimer");
Route::get("/ketentuan-layanan", [PageController::class, "terms"])->name("terms");

Route::middleware('throttle:30,1')->group(function () {
    Route::post("/mora/chat", [MoraChatController::class, "chat"])->name("mora.chat");
    Route::post("/mora/lead", [MoraChatController::class, "lead"])->name("mora.lead");
    Route::post("/b2b/inquiry", [B2bInquiryController::class, "submit"])->name("b2b.inquiry.submit");
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
