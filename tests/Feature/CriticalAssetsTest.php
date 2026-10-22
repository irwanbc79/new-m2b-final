<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Regresi aset kritis halaman depan:
 *  - `logo_m2b_final.svg` 2 MB (raster 2114x1642 tertanam, tampil 52-60 px),
 *  - `hero-port.jpg` 496 KB yang bahkan tidak ada di repo (hanya ada di server),
 *  - dan preload hero yang dipasang di SEMUA halaman padahal hero hanya di home
 *    (setiap kunjungan /blog ikut mengunduh gambar yang tidak dipakai).
 */
class CriticalAssetsTest extends TestCase
{
    use RefreshDatabase;

    private const ASET = [
        'images/logo-m2b-320.webp',
        'images/hero-port.webp',
        'images/hero-port.jpg',
        'images/logo_m2b_final.svg',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(['*' => Http::response('', 200)]);
    }

    public function test_ikon_situs_tersedia_dan_tidak_kosong(): void
    {
        // favicon.ico dulu ada tapi 0 byte, dan tidak ada satu pun
        // <link rel="icon"> di layout → Google tanpa ikon di hasil pencarian.
        $berkas = [
            'favicon.ico' => 1024,
            'favicon-96x96.png' => 1024,
            'favicon-192x192.png' => 1024,
            'favicon-512x512.png' => 1024,
            'apple-touch-icon.png' => 1024,
            'favicon.svg' => 200,
            'site.webmanifest' => 200,
        ];

        foreach ($berkas as $nama => $ukuranMinimal) {
            $path = public_path($nama);

            $this->assertFileExists($path, "Ikon {$nama} hilang dari public/.");
            $this->assertGreaterThan($ukuranMinimal, filesize($path), "Ikon {$nama} kosong atau rusak.");
        }

        $manifest = json_decode((string) file_get_contents(public_path('site.webmanifest')), true);

        $this->assertIsArray($manifest, 'site.webmanifest bukan JSON yang valid.');
        $this->assertSame('#0b1120', $manifest['theme_color'] ?? null);
        $this->assertCount(4, $manifest['icons'] ?? [], 'Manifest harus mendaftarkan ikon 192, 512, maskable, dan SVG.');
    }

    public function test_aset_kritis_tersedia_di_public(): void
    {
        foreach (self::ASET as $aset) {
            $this->assertFileExists(public_path($aset), "Aset {$aset} hilang dari public/.");
        }
    }

    public function test_logo_dan_hero_webp_jauh_lebih_kecil_dari_bentuk_raster_svg(): void
    {
        $logoWebp = filesize(public_path('images/logo-m2b-320.webp'));
        $svg = filesize(public_path('images/logo_m2b_final.svg'));

        $this->assertLessThan(100 * 1024, $logoWebp, 'Logo webp harus di bawah 100 KB.');
        $this->assertLessThan($svg / 10, $logoWebp, 'Logo webp harus minimal 10x lebih kecil dari SVG 2 MB.');
        $this->assertLessThan(300 * 1024, filesize(public_path('images/hero-port.webp')), 'Hero webp harus di bawah 300 KB.');
    }

    public function test_home_menyajikan_logo_dan_hero_lewat_picture_webp(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('images/logo-m2b-320.webp', false);
        $response->assertSee('images/hero-port.webp', false);
        $response->assertSee('type="image/webp"', false);
        // Fallback non-webp tetap disediakan.
        $response->assertSee('images/logo_m2b_final.svg', false);
        $response->assertSee('images/hero-port.jpg', false);
    }

    public function test_halaman_blog_tidak_mengunduh_hero_home(): void
    {
        $response = $this->get('/blog');

        $response->assertOk();
        $response->assertDontSee('images/hero-port', false);
        $response->assertSee('images/logo-m2b-320.webp', false);
    }
}
