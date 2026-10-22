<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Regresi commit dedupe kartu /blog.
 *
 * Markup satu kartu artikel dulu ditulis ulang di grid, di samping lima salinan
 * peta kategori/badge (pill filter, indikator filter aktif, blok featured, kartu
 * grid, widget kategori di sidebar) yang memakai variabel seperti $catEn, $fcEn,
 * $pcEn, $searchData, $daysOld. Sekarang kartu dirender <x-post-card> dan peta
 * itu tinggal di Post::theme() / Post::categoryLabels().
 *
 * Yang dijaga di sini bukan "tampilannya sama persis" (itu urusan QA visual),
 * melainkan empat hal yang mudah rusak tanpa error apa pun:
 *  1. kontrak Alpine pencarian client-side (atribut data-search pada kartu),
 *  2. blok in-feed yang hidup di tengah loop kartu (CTA e-book pada kartu ke-3
 *     dan AdSense pada kartu ke-5) — blok ini nyaris ikut terhapus waktu markup
 *     kartu dipindah, dan hilangnya langsung memotong pendapatan AdSense,
 *  3. label kategori 4 bahasa tetap ikut ter-render dari model, termasuk
 *     fallback untuk kategori yang tidak ada di peta,
 *  4. dua cabang gambar kartu: path relatif lewat Storage::url(), URL absolut
 *     dipakai apa adanya.
 */
class BlogCardRenderTest extends TestCase
{
    use RefreshDatabase;

    /** Jumlah artikel: 1 featured + 7 kartu grid (indeks kartu 0..6). */
    private const JUMLAH_POST = 8;

    protected function setUp(): void
    {
        parent::setUp();

        // View composer layouts.app memanggil Google News RSS, jangan tunggu jaringan.
        Http::fake(['*' => Http::response('', 200)]);

        // Pin slot AdSense supaya cabang "slot valid" yang diuji, bukan fallback
        // dev ("konfigurasi slot tidak valid") yang bergantung isi .env lokal.
        config([
            'services.adsense.publisher_id' => 'ca-pub-5616961797801657',
            'services.adsense.slot_in_feed' => '4457701474',
        ]);

        // Artikel terbaru = Kartu Uji 1 (jadi featured), sisanya masuk grid.
        // Artikel terakhir sengaja pakai kategori di luar peta label.
        // Kartu Uji 2 & 3 menguji dua cabang gambar kartu (path storage vs URL).
        for ($i = 1; $i <= self::JUMLAH_POST; $i++) {
            $kategori = $i === self::JUMLAH_POST ? 'Uncategorized' : 'Ekspor';

            Post::create([
                'title' => 'Kartu Uji '.$i,
                'slug' => 'kartu-uji-'.$i,
                'excerpt' => 'Ringkasan artikel kartu uji '.$i.'.',
                'content' => '<h2>Bagian Uji</h2><p>'.str_repeat('Konten uji kartu blog. ', 20).'</p>',
                'featured_image' => match ($i) {
                    2 => 'posts/kartu-uji-2.jpg',
                    3 => 'https://cdn.example.com/kartu-uji-3.jpg',
                    default => null,
                },
                'meta_description' => 'Deskripsi artikel kartu uji '.$i.'.',
                'category' => $kategori,
                'lang' => 'id',
                'status' => 'published',
                'published_at' => now()->subDays($i - 1),
            ]);
        }
    }

    private function halaman(): string
    {
        return $this->get('/blog')->assertOk()->getContent();
    }

    public function test_setiap_kartu_grid_membawa_data_search_untuk_filter_alpine(): void
    {
        $html = $this->halaman();

        // Kartu Uji 2..8 dirender komponen; Kartu Uji 1 jadi featured dan
        // di-@continue dari grid.
        $this->assertSame(
            self::JUMLAH_POST - 1,
            substr_count($html, '<h3 style="font-family:Syne; font-weight:700; font-size:17px;'),
            'Jumlah kartu grid tidak sesuai jumlah artikel dikurangi featured.'
        );

        // Haystack = judul + ringkasan + kategori dalam huruf kecil. Kalau
        // formatnya berubah, x-show pada kartu berhenti mencocokkan ketikan
        // pengguna dan hasil pencarian jadi kosong tanpa error.
        $this->assertSee($html, 'data-search="kartu uji 3 ringkasan artikel kartu uji 3. ekspor"');
        $this->assertSee($html, 'data-search="kartu uji '.self::JUMLAH_POST.' ringkasan artikel kartu uji '.self::JUMLAH_POST.'. uncategorized"');
    }

    public function test_blok_infeed_cta_ebook_dan_adsense_tetap_dirender_di_tengah_grid(): void
    {
        $html = $this->halaman();

        // CTA e-book: $cardIndex === 2 → setelah kartu ke-3.
        $this->assertSee($html, 'class="infeed-cta"');
        $this->assertSee($html, 'https://ebook.m2b.co.id/toolkit.html');

        // AdSense in_feed: satu setelah featured, satu di $cardIndex === 4.
        $this->assertSame(
            2,
            substr_count($html, 'ad-block-in_feed'),
            'Blok iklan in-feed hilang: harus ada satu setelah featured dan satu setelah kartu ke-5.'
        );
        $this->assertSame(2, substr_count($html, 'data-ad-slot="4457701474"'));
    }

    public function test_kartu_dengan_gambar_membedakan_path_storage_dan_url_absolut(): void
    {
        $html = $this->halaman();

        // Path relatif → dijadikan absolut lewat disk public (dulu relatif
        // "/storage/..."), URL absolut → dipakai apa adanya. Salah cabang =
        // gambar kartu 404. Kartu sekarang <img> (dulu <div background-image>).
        $this->assertSee($html, '<img src="'.asset('storage/posts/kartu-uji-2.jpg').'"');
        $this->assertDontSee($html, 'url(/storage/', 'Kartu kembali memakai URL gambar relatif.');
        $this->assertDontSee($html, 'storage/https');
        $this->assertSee($html, '<img src="https://cdn.example.com/kartu-uji-3.jpg"');
    }

    /**
     * Thumbnail kartu wajib jadi <img>, bukan CSS background-image: crawler
     * gambar Google mengabaikan gambar latar CSS, jadi selama ini tidak satu pun
     * dari 9 kartu di /blog punya peluang muncul di Google Images.
     * Alt + width/height juga wajib: alt = konteks gambar bagi crawler, dimensi
     * eksplisit mencegah layout shift di grid.
     */
    public function test_thumbnail_kartu_dirender_sebagai_img_dengan_alt_dan_dimensi(): void
    {
        $html = $this->halaman();

        $this->assertDontSee($html, 'background-image:url(', 'Thumbnail kartu tidak boleh lagi berupa background-image CSS.');
        $this->assertSee($html, 'alt="Kartu Uji 2"');
        $this->assertSee($html, 'width="400" height="190"');
        $this->assertSee($html, 'loading="lazy"');
    }

    public function test_label_kategori_empat_bahasa_dirender_dari_model(): void
    {
        $html = $this->halaman();

        // Kategori di peta → label terjemahan.
        $this->assertSee($html, "x-text=\"\$store.lang.t('Ekspor', 'Export', '出口', 'التصدير')\"");
        // Kategori di luar peta → fallback teks apa adanya di keempat bahasa.
        $this->assertSee($html, "x-text=\"\$store.lang.t('Uncategorized', 'Uncategorized', 'Uncategorized', 'Uncategorized')\"");
    }

    public function test_tidak_ada_sisa_directive_blade_atau_variabel_peta_lama_di_output(): void
    {
        $html = $this->halaman();

        foreach (['@php', '@endphp', '@forelse', '@continue'] as $directive) {
            $this->assertDontSee($html, $directive);
        }

        foreach (['$catEn', '$fcEn', '$pcEn', '$searchData', '$daysOld', 'themeDefault'] as $sisa) {
            $this->assertDontSee($html, $sisa);
        }
    }

    /**
     * Kartu "Sorotan" /blog = artikel terbaru ($posts->first()), bukan nilai
     * cache terpisah. Dulu ada BlogCache::FEATURED_POST yang dioper controller
     * ke view tapi selalu ditimpa variabel lokal di blade: satu query + satu
     * baris cache per halaman dingin, plus satu sapuan tiap post disimpan —
     * untuk nilai yang tidak pernah dibaca.
     */
    public function test_kartu_sorotan_adalah_artikel_terbaru_tanpa_cache_terpisah(): void
    {
        Cache::flush();

        $html = $this->halaman();

        $this->assertSee($html, '<h2 style="font-family:Syne; font-weight:800; font-size:24px; line-height:1.25; color:#0b1120; margin-bottom:12px">Kartu Uji 1</h2>');

        $this->assertFalse(
            Cache::has('blog_featured_post'),
            'Cache sorotan terpisah sudah dihapus — kartu sorotan memakai $posts->first().'
        );
        $this->assertTrue(
            Cache::has('blog_popular_posts'),
            'Widget popular tetap punya cache sendiri (isinya bergantung hitungan view, bukan urutan publish).'
        );
    }

    private function assertSee(string $html, string $needle): void
    {
        $this->assertStringContainsString($needle, $html, "Tidak menemukan: {$needle}");
    }

    private function assertDontSee(string $html, string $needle, string $pesan = ''): void
    {
        $this->assertStringNotContainsString($needle, $html, $pesan !== '' ? $pesan : "Seharusnya sudah tidak ada: {$needle}");
    }
}
