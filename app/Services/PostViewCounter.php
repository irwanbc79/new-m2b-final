<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Penghitung view artikel blog (dipakai badge "POPULER" & widget Popular di /blog).
 *
 * Kenapa harus lewat service ini, bukan `Cache::increment()` langsung:
 * `DatabaseStore::incrementOrDecrement()` mengembalikan `false` dan tidak membuat
 * barisnya kalau key belum ada (lihat vendor/laravel/framework/src/Illuminate/Cache/DatabaseStore.php).
 * `CACHE_STORE` production m2b.co.id = `database`, jadi
 * `Cache::increment("post_views_{$id}")` yang lama tidak pernah menulis apa pun:
 * hitungan view selalu 0 → `blog_hot_ids` jatuh ke urutan terbaru saja.
 *
 * Service ini men-seed key lewat `Cache::add()` lebih dulu (atomic insert) supaya
 * increment benar-benar berjalan, dan tetap aman untuk store array/file/redis
 * yang memang bisa meng-increment key kosong.
 */
class PostViewCounter
{
    /**
     * Jendela akumulasi view (30 hari) supaya daftar POPULER mengikuti tren
     * terkini, bukan angka kumulatif sejak situs dibuat.
     */
    public const WINDOW = 60 * 60 * 24 * 30;

    public const PREFIX = 'post_views_';

    public function key(int|string $postId): string
    {
        return self::PREFIX . $postId;
    }

    /**
     * Catat satu view dan kembalikan total view terbaru.
     */
    public function hit(int|string $postId): int
    {
        $key = $this->key($postId);

        // View pertama untuk post ini: `add()` sekaligus men-seed nilai 1.
        if (Cache::add($key, 1, self::WINDOW)) {
            return 1;
        }

        // Key yang hilang di tengah window (store database tidak mau
        // meng-increment key kosong) → tulis ulang sebagai 1.
        $total = Cache::increment($key);

        if ($total === false) {
            Cache::put($key, 1, self::WINDOW);

            return 1;
        }

        return (int) $total;
    }

    /**
     * Hapus hitungan view satu post (dipakai saat post dihapus).
     */
    public function forget(int|string $postId): void
    {
        Cache::forget($this->key($postId));
    }

    /**
     * Jumlah view satu post.
     */
    public function count(int|string $postId): int
    {
        return (int) Cache::get($this->key($postId), 0);
    }

    /**
     * Jumlah view banyak post sekaligus (satu query di DatabaseStore::many()).
     *
     * @param  iterable<int|string>  $postIds
     * @return array<int|string, int> di-key oleh post id
     */
    public function counts(iterable $postIds): array
    {
        $ids = [];

        foreach ($postIds as $id) {
            $ids[] = $id;
        }

        if ($ids === []) {
            return [];
        }

        $values = Cache::many(array_map(fn ($id) => $this->key($id), $ids));

        $counts = [];
        foreach ($ids as $id) {
            $counts[$id] = (int) ($values[$this->key($id)] ?? 0);
        }

        return $counts;
    }

    /**
     * Post id dengan view terbanyak (desc), hanya yang punya view > 0.
     *
     * @param  iterable<int|string>  $postIds
     * @return array<int, int|string>
     */
    public function topIds(iterable $postIds, int $limit = 3): array
    {
        $counts = array_filter($this->counts($postIds));

        if ($counts === []) {
            return [];
        }

        arsort($counts);

        return array_slice(array_keys($counts), 0, $limit);
    }
}
