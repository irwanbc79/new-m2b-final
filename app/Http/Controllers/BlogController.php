<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostViewCounter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /** Batas halaman yang di-cache, sejajar dengan jangkauan Post::clearIndexCache(). */
    private const MAX_CACHED_PAGE = 20;

    public function index(PostViewCounter $views)
    {
        // ── Normalisasi input GET ────────────────────────────────────────────
        // Semua nilai di bawah dipakai untuk cache key dan direfleksikan ke view,
        // jadi TIDAK boleh dipakai mentah:
        //  - ?search[]=x / ?category[]=x  → array sampai ke Str::slug() &
        //    htmlspecialchars() = TypeError (HTTP 500), dan ke view = error Alpine.
        //  - category bebas → cache key `blog_index_1_<apa-saja>` tanpa batas di
        //    store `database` (baris cache menumpuk). Hanya kategori resmi yang
        //    boleh masuk, karena Post::clearIndexCache() cuma menyapu 6 kategori
        //    resmi × 20 halaman.
        //  - page bebas → sama, cache key tak terbatas; di atas MAX_CACHED_PAGE
        //    (batas yang sama dengan sapuan clearIndexCache) query langsung.
        $rawCategory = request()->get('category');
        $category = is_string($rawCategory) && in_array($rawCategory, Post::CATEGORIES, true)
            ? $rawCategory
            : null;

        $rawSearch = request()->get('search');
        $search = is_string($rawSearch) ? mb_substr(trim($rawSearch), 0, 100) : '';

        $page     = max(1, (int) request()->get('page', 1));
        $cacheKey = 'blog_index_' . $page . ($category ? '_' . Str::slug($category) : '');

        $query = Post::published()->latest('published_at');
        if ($category) {
            $query->where('category', $category);
        }

        $posts = $page <= self::MAX_CACHED_PAGE
            ? Cache::remember($cacheKey, 3600, fn () => $query->paginate(9))
            : $query->paginate(9);

        $categories = collect(Post::CATEGORIES);

        // POPULER = 3 post dengan view terbanyak (jendela 30 hari). Kalau belum ada
        // view sama sekali, daftar kosong dan widget popular jatuh ke post terbaru.
        $hotIds = Cache::remember('blog_hot_ids', 3600, function () use ($views) {
            return $views->topIds(Post::published()->pluck('id')->all(), 3);
        });

        $featured = Cache::remember('blog_featured_post', 3600, function () {
            return Post::published()->latest('published_at')->first();
        });

        $popular = Cache::remember('blog_popular_posts', 3600, function () use ($hotIds, $views) {
            $pop = $hotIds
                ? Post::published()->whereIn('id', $hotIds)->get()
                    ->sortByDesc(fn ($p) => $views->count($p->id))
                    ->values()
                : collect();

            if ($pop->isEmpty()) {
                return Post::published()->latest('published_at')->take(4)->get();
            }

            return $pop;
        });

        return view("pages.blog.index", compact("posts", "categories", "hotIds", "category", "featured", "popular", "search"));
    }

    public function show(string $slug, PostViewCounter $views)
    {
        $post = Cache::remember("blog_post_{$slug}", 3600, function () use ($slug) {
            return Post::where("slug",$slug)->where("status","published")->first();
        });

        if (!$post) {
            // Slug lama dari migrasi WP bisa berisi emoji / sisa percent-encoding.
            // Coba versi bersihnya; kalau ada, redirect permanen ke URL kanonis.
            $clean = preg_replace('/-{2,}/', '-', trim(preg_replace('/[^A-Za-z0-9\-]+/', '', $slug), '-'));
            if ($clean !== '' && $clean !== $slug && Post::where('slug', $clean)->where('status', 'published')->exists()) {
                return redirect("/blog/{$clean}", 301);
            }
            abort(404);
        }

        // Hitungan view HARUS lewat PostViewCounter: Cache::increment() mentah
        // mengembalikan false tanpa menulis apa pun kalau key belum ada (perilaku
        // DatabaseStore), jadi di production (CACHE_STORE=database) semua view
        // hilang → daftar POPULER rusak.
        $views->hit($post->id);
        // Note: blog_hot_ids is intentionally NOT forgotten here. View counts change on
        // every show(); forgetting on each one defeated the 1h TTL and forced a DB
        // recompute on the next index load. The hot list now refreshes at most hourly
        // (and immediately when a post is saved/deleted via Post model hooks).

        $related = Cache::remember("blog_related_{$post->id}", 3600, function () use ($post) {
            $query = Post::published()->where("id","!=",$post->id);
            if ($post->category) {
                $query->where("category", $post->category);
            }
            return $query->limit(3)->get();
        });

        return view("pages.blog.show", compact("post","related"));
    }

    public function feed()
    {
        $posts = Cache::remember('blog_feed', 3600, function () {
            return Post::published()->take(20)->get();
        });

        return response()
            ->view('pages.blog.feed', compact('posts'))
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    public function kalkulator()
    {
        return view("pages.blog.kalkulator");
    }
}