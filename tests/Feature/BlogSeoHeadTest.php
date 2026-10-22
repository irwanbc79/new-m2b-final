<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Head SEO halaman blog — hasil audit m2b.co.id 22 Oktober 2026.
 *
 * Semua yang dijaga di sini rusak tanpa gejala (halaman tetap 200, hanya laporan
 * Google Search Console yang berubah):
 *  1. kanonikal /blog = https://m2b.co.id/blog/ (bentuk ber-trailing-slash).
 *     /blog tanpa slash dijawab edge hCDN dengan 301 → /blog/, jadi kanonikal
 *     lama mengarah ke URL yang redirect,
 *  2. ?search=… tidak lagi index,follow (HTML dari server identik dengan halaman
 *     pertama; penyaringan dikerjakan Alpine di browser),
 *  3. halaman 2+ kanonikal ke dirinya sendiri, bukan dikonsolidasi ke halaman 1,
 *  4. tepat satu <h1> di halaman artikel (H1 duplikat dari body CMS dibuang),
 *  5. meta description ≤155 karakter (kolom CMS bisa 185 karakter),
 *  6. <link rel="icon">, apple-touch-icon, manifest, dan theme-color terpasang.
 */
class BlogSeoHeadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // View composer layouts.app memanggil Google News RSS, jangan tunggu jaringan.
        Http::fake(['*' => Http::response('', 200)]);

        // CACHE_STORE=array tidak dibersihkan antar test dalam satu proses,
        // sedangkan index /blog di-cache per halaman.
        Cache::flush();
    }

    public function test_kanonikal_blog_memakai_bentuk_trailing_slash(): void
    {
        $this->artikel(1);

        $html = $this->get('/blog')->assertOk()->getContent();

        $this->assertStringContainsString(
            '<link rel="canonical" href="https://m2b.co.id/blog/">',
            $html,
            'Kanonikal /blog harus memakai bentuk ber-trailing-slash yang dijawab 200.'
        );
        $this->assertStringContainsString('<meta property="og:url" content="https://m2b.co.id/blog/">', $html);
    }

    public function test_halaman_blog_tanpa_filter_tetap_index_follow(): void
    {
        $this->artikel(1);

        $html = $this->get('/blog')->assertOk()->getContent();

        $this->assertStringContainsString('<meta name="robots" content="index, follow">', $html);
    }

    public function test_halaman_hasil_pencarian_noindex_kanonikal_ke_blog(): void
    {
        $this->artikel(1);

        $html = $this->get('/blog?search=bea+cukai')->assertOk()->getContent();

        $this->assertStringContainsString(
            '<meta name="robots" content="noindex, follow">',
            $html,
            'Halaman ?search= tidak boleh ikut diindeks.'
        );
        $this->assertStringContainsString('<link rel="canonical" href="https://m2b.co.id/blog/">', $html);
    }

    public function test_halaman_dua_kanonikal_ke_dirinya_sendiri(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->artikel($i);
        }

        $html = $this->get('/blog?page=2')->assertOk()->getContent();

        $this->assertStringContainsString(
            '<link rel="canonical" href="https://m2b.co.id/blog/?page=2">',
            $html,
            'Halaman 2 harus kanonikal ke dirinya sendiri, bukan dikonsolidasi ke halaman 1.'
        );
        $this->assertStringContainsString('<meta name="robots" content="index, follow">', $html);
    }

    public function test_halaman_artikel_punya_tepat_satu_h1(): void
    {
        $post = $this->artikel(1, '<h1 id="judul-artikel-1">Judul Artikel 1</h1>'
            .'<p>Paragraf pertama artikel uji.</p>'
            .'<h1>Heading lain di dalam body</h1>'
            .'<p>Paragraf kedua artikel uji.</p>');

        $html = $this->get('/blog/'.$post->slug)->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, '<h1'), 'Halaman artikel harus punya tepat satu <h1>.');
        $this->assertStringContainsString('<h2>Heading lain di dalam body</h2>', $html);
        $this->assertStringNotContainsString(
            'id="judul-artikel-1"',
            $html,
            'H1 duplikat judul dibuang utuh (atribut id-nya tidak punya tautan jangkar).'
        );
    }

    public function test_meta_description_artikel_dipotong_maksimal_155_karakter(): void
    {
        $panjang = 'Panduan lengkap cara impor sparepart pesawat untuk pemula, mulai dari dokumen PIB, larangan dan pembatasan, sampai memilih jasa PPJK berlisensi supaya barang tidak tertahan lama di pelabuhan dan biaya logistik tetap terkendali.';
        $this->assertGreaterThan(155, mb_strlen($panjang));

        $post = $this->artikel(1, null, $panjang);

        $html = $this->get('/blog/'.$post->slug)->assertOk()->getContent();

        preg_match('/<meta name="description" content="([^"]*)"/', $html, $cocok);

        $this->assertNotEmpty($cocok, 'Meta description tidak dirender.');
        $this->assertLessThanOrEqual(155, mb_strlen($cocok[1]), 'Google memangkas deskripsi di sekitar 155 karakter.');
        $this->assertSame($post->meta_description, $cocok[1]);
    }

    public function test_head_memuat_ikon_situs_manifest_dan_theme_color(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        foreach (['favicon.ico', 'favicon.svg', 'favicon-96x96.png', 'apple-touch-icon.png'] as $ikon) {
            $this->assertStringContainsString(asset($ikon), $html, "Head tidak memuat pautan ikon {$ikon}.");
        }

        $this->assertStringContainsString('rel="manifest"', $html);
        $this->assertStringContainsString('<meta name="theme-color" content="#0b1120">', $html);
    }

    public function test_deskripsi_ber_ampersand_dihitung_setelah_entity_didekode(): void
    {
        // Kasus nyata /blog/cara-impor-sparepart-panduan-lengkap-pemula: deskripsi
        // terbaca 158 karakter di HTML mentah karena "&" di-escape Blade menjadi
        // "&amp;" (5 karakter). Teks aslinya 154 karakter — sudah di bawah batas
        // Google. Gate scripts/smoke-blog.sh pernah melaporkan ini sebagai gagal,
        // jadi invariant yang dijaga di sini ada dua: pemangkasan tetap ≤155
        // SETELAH entity didekode, dan og/twitter memakai nilai yang identik.
        $panjang = 'Ingin impor sparepart tapi bingung caranya? Panduan lengkap ini akan membantu Anda! Pelajari semua langkah penting & temukan solusi impor sparepart mudah bersama praktisi PPJK M2B.';
        $this->assertGreaterThan(155, mb_strlen($panjang), 'Data uji harus lebih panjang dari batas Google.');

        $post = $this->artikel(1, null, $panjang);

        $html = $this->get('/blog/'.$post->slug)->assertOk()->getContent();

        preg_match('/<meta name="description" content="([^"]*)"/', $html, $cocok);
        $this->assertNotEmpty($cocok, 'Meta description tidak dirender.');
        $this->assertStringContainsString('&amp;', $cocok[1], 'Ampersand harus ter-escape sebagai entity di atribut.');

        $teks = html_entity_decode($cocok[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $this->assertLessThanOrEqual(155, mb_strlen($teks), 'Panjang diukur setelah entity didekode.');
        $this->assertGreaterThan(100, mb_strlen($teks), 'Deskripsi tidak boleh terpotong terlalu pendek.');
        $this->assertStringStartsWith('Ingin impor sparepart', $teks);
        $this->assertStringEndsWith('…', $teks, 'Pemangkasan ditandai elipsis.');

        $this->assertStringContainsString('<meta property="og:description" content="'.$cocok[1].'">', $html);
        $this->assertStringContainsString('<meta name="twitter:description" content="'.$cocok[1].'">', $html);
    }

    private function artikel(int $i, ?string $content = null, ?string $metaDescription = null): Post
    {
        return Post::create([
            'title' => 'Judul Artikel '.$i,
            'slug' => 'judul-artikel-'.$i,
            'excerpt' => 'Ringkasan artikel '.$i.'.',
            'content' => $content ?? '<h1 id="judul-artikel-'.$i.'">Judul Artikel '.$i.'</h1><p>'.str_repeat('Konten uji artikel blog. ', 40).'</p>',
            'meta_description' => $metaDescription ?? 'Deskripsi artikel '.$i.'.',
            'category' => 'Ekspor',
            'lang' => 'id',
            'status' => 'published',
            'published_at' => now()->subDays($i - 1),
        ]);
    }
}
