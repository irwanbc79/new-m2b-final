<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Services\PostViewCounter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Kontrak query POPULER / "Baca Juga" yang sekarang tinggal di model Post:
 * Post::popularFor(), Post::relatedFor(), dan scopeHot().
 *
 * Sebelumnya tiga builder ini ditulis inline di BlogController dengan dua
 * panggilan PostViewCounter::count() per artikel dan urutan yang bergantung
 * pada alur closure berlapis. Sekarang kontraknya diuji langsung di model.
 *
 * Urutan POPULER datang dari counter cache (bukan kolom DB), jadi salah urut
 * tidak memunculkan error apa pun — hanya badge & sidebar menampilkan artikel
 * yang salah. Karena itu urutan dan jalur fallback dipatok di sini.
 */
class BlogPostQueryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Store `database` = yang dipakai production m2b.co.id; store `array`
        // menyembunyikan bug increment (lihat BlogViewCounterTest).
        config(['cache.default' => 'database']);
        Cache::flush();
    }

    public function test_popular_for_mengurutkan_berdasarkan_jumlah_view(): void
    {
        $views = app(PostViewCounter::class);
        $sepi = $this->buatPost('populer-sepi', 1);
        $ramai = $this->buatPost('populer-ramai', 2);
        $sedang = $this->buatPost('populer-sedang', 3);

        $views->hit($sepi->id);
        $views->hit($ramai->id);
        $views->hit($ramai->id);
        $views->hit($ramai->id);
        $views->hit($sedang->id);
        $views->hit($sedang->id);

        $hotIds = $views->topIds(Post::published()->pluck('id')->all(), 3);
        $popular = Post::popularFor($hotIds, $views, 4);

        $this->assertSame(
            [$ramai->id, $sedang->id, $sepi->id],
            array_map('intval', $popular->pluck('id')->all())
        );
    }

    public function test_popular_for_jatuh_ke_post_terbaru_kalau_belum_ada_view(): void
    {
        $lama = $this->buatPost('fallback-lama', 5);
        $baru = $this->buatPost('fallback-baru', 1);

        $popular = Post::popularFor([], app(PostViewCounter::class), 4);

        $this->assertSame(
            [$baru->id, $lama->id],
            array_map('intval', $popular->pluck('id')->all())
        );
    }

    public function test_popular_for_jatuh_ke_post_terbaru_kalau_id_hot_sudah_tidak_published(): void
    {
        $views = app(PostViewCounter::class);
        $draft = $this->buatPost('populer-draft', 3, 'draft');
        $terbit = $this->buatPost('populer-terbit', 1);

        // Id di cache `blog_hot_ids` bisa tertinggal saat artikel di-unpublish.
        $views->hit($draft->id);
        $views->hit($draft->id);

        $popular = Post::popularFor([$draft->id], $views, 4);

        $this->assertSame([$terbit->id], array_map('intval', $popular->pluck('id')->all()));
    }

    public function test_popular_for_menghormati_batas_fallback(): void
    {
        $this->buatPost('batas-1', 1);
        $this->buatPost('batas-2', 2);
        $this->buatPost('batas-3', 3);

        $popular = Post::popularFor([], app(PostViewCounter::class), 2);

        $this->assertCount(2, $popular);
    }

    public function test_scope_hot_hanya_mengambil_id_yang_diminta_dan_status_published(): void
    {
        $terbit = $this->buatPost('hot-terbit', 3);
        $lain = $this->buatPost('hot-lain', 2);
        $draft = $this->buatPost('hot-draft', 1, 'draft');

        $hasil = array_map('intval', Post::published()->hot([$terbit->id, $draft->id])->pluck('id')->all());

        $this->assertSame([$terbit->id], $hasil);
        $this->assertNotContains($lain->id, $hasil);
    }

    public function test_related_for_mengambil_kategori_sama_tanpa_artikel_itu_sendiri(): void
    {
        $utama = $this->buatPost('baca-juga-utama', 6, 'published', 'Ekspor');
        $sama = $this->buatPost('baca-juga-sama', 5, 'published', 'Ekspor');
        $lain = $this->buatPost('baca-juga-lain', 4, 'published', 'Impor');

        $related = array_map('intval', Post::relatedFor($utama, 3)->pluck('id')->all());

        $this->assertSame([$sama->id], $related);
        $this->assertNotContains($lain->id, $related);
        $this->assertNotContains($utama->id, $related);
    }

    public function test_related_for_menghormati_batas_jumlah(): void
    {
        $utama = $this->buatPost('batas-juga-utama', 6, 'published', 'Ekspor');
        $this->buatPost('batas-juga-1', 5, 'published', 'Ekspor');
        $this->buatPost('batas-juga-2', 4, 'published', 'Ekspor');

        $this->assertCount(2, Post::relatedFor($utama, 2));
    }

    public function test_related_for_tanpa_kategori_mengambil_artikel_terbaru_lain(): void
    {
        $utama = $this->buatPost('tanpa-kategori-utama', 6, 'published', null);
        $lain = $this->buatPost('tanpa-kategori-lain', 4, 'published', 'Impor');

        $related = array_map('intval', Post::relatedFor($utama, 3)->pluck('id')->all());

        $this->assertSame([$lain->id], $related);
    }

    private function buatPost(string $slug, int $hariLalu, string $status = 'published', ?string $category = 'Ekspor'): Post
    {
        return Post::create([
            'title' => 'Artikel '.$slug,
            'slug' => $slug,
            'excerpt' => 'Ringkasan artikel '.$slug.'.',
            'content' => '<h2>Bagian Uji</h2><p>'.str_repeat('Konten uji query blog. ', 20).'</p>',
            'meta_description' => 'Deskripsi artikel uji '.$slug.'.',
            'category' => $category,
            'lang' => 'id',
            'status' => $status,
            'published_at' => now()->subDays($hariLalu),
        ]);
    }
}
