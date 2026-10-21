<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\BlogCache;
use App\Services\PostViewCounter;

class BlogController extends Controller
{
    public function index(PostViewCounter $views, BlogCache $cache)
    {
        // ── Normalisasi input GET ────────────────────────────────────────────
        // Semua nilai di bawah dipakai untuk cache key dan direfleksikan ke view,
        // jadi TIDAK boleh dipakai mentah:
        //  - ?search[]=x / ?category[]=x  → array sampai ke Str::slug() &
        //    htmlspecialchars() = TypeError (HTTP 500), dan ke view = error Alpine.
        //  - category bebas → cache key `blog_index_1_<apa-saja>` tanpa batas di
        //    store `database` (baris cache menumpuk). Hanya kategori resmi yang
        //    boleh masuk, karena BlogCache::forgetIndexes() cuma menyapu 6 kategori
        //    resmi × BlogCache::MAX_CACHED_PAGE halaman.
        //  - page bebas → sama, cache key tak terbatas; di atas MAX_CACHED_PAGE
        //    (batas yang sama dengan sapuan forgetIndexes) query langsung.
        $rawCategory = request()->get('category');
        $category = is_string($rawCategory) && in_array($rawCategory, Post::CATEGORIES, true)
            ? $rawCategory
            : null;

        $rawSearch = request()->get('search');
        $search = is_string($rawSearch) ? mb_substr(trim($rawSearch), 0, 100) : '';

        $page     = max(1, (int) request()->get('page', 1));
        $cacheKey = $cache->indexKey($page, $category);

        $query = Post::published();
        if ($category) {
            $query->where('category', $category);
        }

        $posts = $page <= BlogCache::MAX_CACHED_PAGE
            ? $cache->remember($cacheKey, fn () => $query->paginate(BlogCache::PER_PAGE))
            : $query->paginate(BlogCache::PER_PAGE);

        $categories = collect(Post::CATEGORIES);

        // POPULER = 3 post dengan view terbanyak (jendela 30 hari). Kalau belum ada
        // view sama sekali, daftar kosong dan widget popular jatuh ke post terbaru.
        $hotIds = $cache->remember(BlogCache::HOT_IDS, function () use ($views) {
            return $views->topIds(Post::published()->pluck('id')->all(), BlogCache::HOT_LIMIT);
        });

        $featured = $cache->remember(BlogCache::FEATURED_POST, fn () => Post::published()->first());

        $popular = $cache->remember(
            BlogCache::POPULAR_POSTS,
            fn () => Post::popularFor($hotIds ?? [], $views, BlogCache::POPULAR_FALLBACK_LIMIT)
        );

        return view("pages.blog.index", compact("posts", "categories", "hotIds", "category", "featured", "popular", "search"));
    }

    public function show(string $slug, PostViewCounter $views, BlogCache $cache)
    {
        $post = $cache->remember($cache->postKey($slug), function () use ($slug) {
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

        $related = $cache->remember(
            $cache->relatedKey($post->id),
            fn () => Post::relatedFor($post, BlogCache::RELATED_LIMIT)
        );

        return view("pages.blog.show", compact("post","related"));
    }

    public function feed(BlogCache $cache)
    {
        $posts = $cache->remember(BlogCache::FEED, function () {
            return Post::published()->take(BlogCache::FEED_LIMIT)->get();
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