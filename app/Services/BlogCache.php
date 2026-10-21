<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Sumber tunggal cache key + TTL untuk seluruh halaman blog publik.
 *
 * Sebelum ini key ditulis sebagai string literal di tiga tempat berbeda
 * (BlogController, Post::clearBlogCache(), Post::clearIndexCache()) — satu typo
 * di salah satu tempat membuat invalidasi diam-diam tidak jalan dan halaman
 * menyajikan data basi sampai TTL habis. Semua key sekarang hanya didefinisikan
 * di sini; controller memakai `indexKey()/postKey()/relatedKey()` dan model
 * memakai `forgetAll()` saat post disimpan/dihapus.
 *
 * Catatan bentuk key (dipatok oleh tests/Feature/BlogSearchHardeningTest.php dan
 * BlogViewCounterTest.php): `blog_index_<page>[_<slug-kategori>]`, `blog_post_<slug>`,
 * `blog_related_<id>`, `blog_hot_ids`, `blog_popular_posts`, `blog_featured_post`,
 * `blog_feed`.
 */
class BlogCache
{
    /** TTL semua cache halaman blog (detik). */
    public const TTL = 3600;

    /** Batas halaman /blog yang di-cache; di atas ini query langsung ke DB. */
    public const MAX_CACHED_PAGE = 20;

    /** Jumlah artikel POPULER (badge + widget sidebar). */
    public const HOT_LIMIT = 3;

    /** Jumlah artikel widget Popular saat belum ada view sama sekali. */
    public const POPULAR_FALLBACK_LIMIT = 4;

    /** Jumlah artikel di feed RSS. */
    public const FEED_LIMIT = 20;

    /** Jumlah artikel "Baca Juga" di halaman detail. */
    public const RELATED_LIMIT = 3;

    /** Artikel per halaman di /blog. */
    public const PER_PAGE = 9;

    /** Daftar id POPULER (urut view desc) — sumber badge POPULER. */
    public const HOT_IDS = 'blog_hot_ids';

    /** Widget Popular di sidebar (3 post + fallback). */
    public const POPULAR_POSTS = 'blog_popular_posts';

    /** Kartu "Sorotan" di /blog. */
    public const FEATURED_POST = 'blog_featured_post';

    /** Feed RSS /blog/feed. */
    public const FEED = 'blog_feed';

    /**
     * Cache::remember dengan TTL standar blog, supaya TTL tidak pernah
     * ditulis ulang (dan tidak drift) di controller.
     */
    public function remember(string $key, \Closure $callback): mixed
    {
        return Cache::remember($key, self::TTL, $callback);
    }

    public function indexKey(int $page, ?string $category = null): string
    {
        return 'blog_index_' . $page . ($category ? '_' . Str::slug($category) : '');
    }

    public function postKey(string $slug): string
    {
        return 'blog_post_' . $slug;
    }

    public function relatedKey(int|string $postId): string
    {
        return 'blog_related_' . $postId;
    }

    /**
     * Cache daftar/agregat: isinya berubah setiap ada post disimpan atau dihapus
     * (termasuk unpublish, pergantian kategori, dan hapus).
     *
     * `blog_popular_posts` dan `blog_featured_post` dulu TIDAK pernah
     * di-invalidate: post yang di-unpublish/dihapus tetap tampil di widget
     * popular sampai TTL 1 jam habis, dan post terbaru tidak muncul sebagai
     * featured.
     */
    public function forgetLists(): void
    {
        Cache::forget(self::HOT_IDS);
        Cache::forget(self::POPULAR_POSTS);
        Cache::forget(self::FEATURED_POST);
        Cache::forget(self::FEED);
    }

    public function forgetPost(string $slug): void
    {
        Cache::forget($this->postKey($slug));
    }

    public function forgetRelated(int|string $postId): void
    {
        Cache::forget($this->relatedKey($postId));
    }

    /**
     * Sapu semua halaman /blog yang di-cache: MAX_CACHED_PAGE halaman ×
     * (tanpa kategori + semua kategori resmi). Hanya kategori resmi yang perlu
     * disapu karena BlogController menolak `?category=` di luar Post::CATEGORIES.
     */
    public function forgetIndexes(): void
    {
        $categorySlugs = ['', ...array_map(static fn (string $cat): string => Str::slug($cat), Post::CATEGORIES)];

        for ($page = 1; $page <= self::MAX_CACHED_PAGE; $page++) {
            foreach ($categorySlugs as $slug) {
                Cache::forget($this->indexKey($page, $slug ?: null));
            }
        }
    }

    /**
     * Semua cache yang isinya bergantung pada isi tabel posts.
     */
    public function forgetAll(): void
    {
        $this->forgetLists();
        $this->forgetIndexes();
    }
}
