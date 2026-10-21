<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Regresi XSS: nilai `search` dari query string dulu ditempel ke atribut Alpine
 * (`x-data="{ search: '{{ $search }}' }"`). Karena browser men-decode entity HTML
 * di dalam atribut, `&#039;` kembali menjadi kutip tunggal dan payload
 * /blog?search='+alert(1)+' keluar dari string JS lalu dieksekusi.
 *
 * Sekarang nilainya lewat JSON.parse (Js::from) dan dinormalisasi di controller.
 * Dua hal yang dijaga di sini:
 *  1. tidak ada lagi kutip tunggal hasil decode entity di dalam string JS,
 *  2. input aneh (?search[]=x, kategori liar, page liar) tidak jadi 500 atau
 *     menumbuhkan cache store `database` tanpa batas.
 */
class BlogSearchHardeningTest extends TestCase
{
    use RefreshDatabase;

    private const JUDUL = 'Artikel Uji Hardening Pencarian';

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(['*' => Http::response('', 200)]);

        Post::create([
            'title' => self::JUDUL,
            'slug' => 'artikel-uji-hardening-pencarian',
            'excerpt' => 'Ringkasan artikel uji hardening pencarian.',
            'content' => '<p>'.str_repeat('Konten uji hardening pencarian. ', 20).'</p>',
            'meta_description' => 'Deskripsi uji hardening pencarian.',
            'category' => 'Ekspor',
            'lang' => 'id',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function test_payload_xss_tidak_direfleksikan_mentah_di_atribut_alpine(): void
    {
        $response = $this->get('/blog?search='.urlencode("'+alert(1)+'"));

        $response->assertOk();
        // Bentuk lama yang rentan: kutip tunggal di-encode jadi entity HTML,
        // browser men-decode-nya kembali di dalam atribut → string JS terputus.
        $response->assertDontSee('&#039;+alert(1)+&#039;', false);
        // Bentuk sekarang: kutip tunggal di-escape sebagai \u0027 di dalam string JS,
        // jadi tidak ada kutip mentah yang bisa keluar dari atribut Alpine.
        $response->assertSee("\\u0027+alert(1)+\\u0027", false);
        $response->assertDontSee("search: ''+alert", false);
    }

    public function test_payload_penutup_atribut_tidak_bisa_keluar_dari_x_data(): void
    {
        $payload = '"><img src=x onerror=alert(1)>';
        $response = $this->get('/blog?search='.urlencode($payload));

        $response->assertOk();
        $response->assertDontSee($payload, false);
        $response->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_search_dipotong_seratus_karakter(): void
    {
        $panjang = str_repeat('a', 150);
        $response = $this->get('/blog?search='.$panjang);

        $response->assertOk();
        $response->assertDontSee($panjang, false);
        $response->assertSee(str_repeat('a', 100), false);
    }

    public function test_query_berbentuk_array_tidak_menyebabkan_error_500(): void
    {
        $this->get('/blog?search[]=x')->assertOk();
        $this->get('/blog?category[]=x')->assertOk();
        $this->get('/blog?page[]=2')->assertOk();
        $this->get('/blog?page=abc')->assertOk();
    }

    public function test_kategori_di_luar_daftar_resmi_diabaikan_dan_tidak_membuat_cache_key(): void
    {
        $response = $this->get('/blog?category=Kategori-Palsu');

        $response->assertOk();
        $response->assertSee(self::JUDUL, false);
        $this->assertFalse(
            Cache::has('blog_index_1_kategori-palsu'),
            'Kategori liar tidak boleh menumbuhkan cache store.'
        );
    }

    public function test_page_di_atas_batas_tidak_membuat_cache_key(): void
    {
        $this->get('/blog?page=2')->assertOk();
        $this->assertTrue(Cache::has('blog_index_2'), 'Halaman wajar tetap di-cache.');

        $this->get('/blog?page=99999')->assertOk();
        $this->assertFalse(
            Cache::has('blog_index_99999'),
            'Nomor halaman liar tidak boleh menumbuhkan cache store.'
        );
    }
}
