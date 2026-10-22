<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Services\PostViewCounter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Regresi bug production: hitungan view artikel mati karena CACHE_STORE=database.
 * `Cache::increment()` pada DatabaseStore mengembalikan false dan TIDAK menulis
 * apa pun kalau key belum ada, jadi `post_views_{id}` tidak pernah terbentuk dan
 * daftar POPULER selalu kosong (urutannya jatuh ke id terlama).
 *
 * Test ini sengaja memakai store `database` (phpunit.xml memakai `array`) supaya
 * bug tersebut benar-benar tertangkap kalau nanti muncul lagi.
 */
class BlogViewCounterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['cache.default' => 'database']);
        Cache::flush();

        // View composer layouts.app memanggil Google News RSS, jangan tunggu jaringan.
        Http::fake(['*' => Http::response('', 200)]);
    }

    public function test_membaca_artikel_menambah_hitungan_view_di_store_database(): void
    {
        $post = $this->buatPost('artikel-uji-view', 'Artikel Uji Hitungan View');

        $this->get('/blog/'.$post->slug)->assertOk();
        $this->get('/blog/'.$post->slug)->assertOk();

        $this->assertSame(2, app(PostViewCounter::class)->count($post->id));
    }

    public function test_hot_ids_mengikuti_jumlah_view_dan_mengecualikan_post_tanpa_view(): void
    {
        $populer = $this->buatPost('artikel-populer', 'Artikel Populer');
        $biasa = $this->buatPost('artikel-biasa', 'Artikel Biasa');
        $sepi = $this->buatPost('artikel-sepi', 'Artikel Sepi');

        $views = app(PostViewCounter::class);
        $views->hit($biasa->id);
        $views->hit($populer->id);
        $views->hit($populer->id);

        $this->get('/blog')->assertOk();

        $hotIds = array_map('intval', Cache::get('blog_hot_ids'));

        $this->assertSame([$populer->id, $biasa->id], $hotIds);
        $this->assertNotContains($sepi->id, $hotIds);
    }

    public function test_cache_populer_dan_hitungan_view_disapu_saat_post_berubah(): void
    {
        $post = $this->buatPost('artikel-uji-invalidate', 'Artikel Uji Invalidate');
        $keys = ['blog_hot_ids', 'blog_popular_posts', 'blog_feed'];

        app(PostViewCounter::class)->hit($post->id);

        foreach ($keys as $key) {
            Cache::put($key, 'nilai-lama', 3600);
        }

        $post->update(['title' => 'Artikel Uji Invalidate (revisi)']);

        foreach ($keys as $key) {
            $this->assertFalse(Cache::has($key), "Cache {$key} harus disapu setelah post disimpan.");
        }

        $viewKey = app(PostViewCounter::class)->key($post->id);
        Cache::put('blog_popular_posts', 'nilai-lama', 3600);

        $post->delete();

        $this->assertFalse(Cache::has('blog_popular_posts'), 'Widget popular tidak boleh menyimpan model yang sudah dihapus.');
        $this->assertFalse(Cache::has($viewKey), 'Hitungan view post yang dihapus harus dibuang.');
    }

    public function test_hit_pertama_mengembalikan_satu_dan_berikutnya_menambah(): void
    {
        $views = app(PostViewCounter::class);

        $this->assertSame(1, $views->hit(987654));
        $this->assertSame(2, $views->hit(987654));
        $this->assertSame(3, $views->hit(987654));
        $this->assertSame(3, $views->count(987654));
        $this->assertSame(0, $views->count(111111));
        $this->assertSame([], $views->topIds([111111], 3));
        $this->assertSame([987654], $views->topIds([987654, 111111], 3));
    }

    private function buatPost(string $slug, string $judul): Post
    {
        return Post::create([
            'title' => $judul,
            'slug' => $slug,
            'excerpt' => 'Ringkasan '.$judul.'.',
            'content' => '<h2>Bagian Uji</h2><p>'.str_repeat('Konten uji hitungan view. ', 20).'</p>',
            'meta_description' => 'Deskripsi '.$judul.'.',
            'category' => 'Ekspor',
            'lang' => 'id',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
