<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * `php artisan sitemap:generate`.
 *
 * Sebelum ini perintah memakai Spatie\Sitemap\Sitemap yang TIDAK ada di
 * composer.json/composer.lock, sehingga selalu berhenti dengan
 * "Class Spatie\Sitemap\Sitemap not found" pada instalasi hasil composer install
 * (sitemap publik yang beredar dibuat versi lama yang paketnya masih ada).
 * Sekarang XML ditulis dengan DOMDocument, dan URL /blog memakai trailing slash
 * karena /blog tanpa slash dijawab 301 oleh edge hCDN — sitemap tidak boleh
 * memuat URL yang di-redirect.
 */
class SitemapGenerationTest extends TestCase
{
    use RefreshDatabase;

    private string $sitemapAsli;

    protected function setUp(): void
    {
        parent::setUp();

        // Perintah menulis langsung ke public/sitemap.xml (berkas yang ikut
        // ter-commit). Simpan isinya agar test tidak mengubah isi repo.
        $this->sitemapAsli = (string) file_get_contents(public_path('sitemap.xml'));
    }

    protected function tearDown(): void
    {
        file_put_contents(public_path('sitemap.xml'), $this->sitemapAsli);

        parent::tearDown();
    }

    public function test_sitemap_memuat_blog_ber_trailing_slash_dan_hanya_artikel_published(): void
    {
        $this->artikel('artikel-published', 'published');
        $this->artikel('artikel-draft', 'draft');

        $this->artisan('sitemap:generate')->assertSuccessful();

        $xml = (string) file_get_contents(public_path('sitemap.xml'));

        $this->assertStringContainsString('<loc>https://m2b.co.id/blog/</loc>', $xml);
        $this->assertStringNotContainsString(
            '<loc>https://m2b.co.id/blog</loc>',
            $xml,
            '/blog tanpa trailing slash adalah URL yang di-redirect (301 → /blog/).'
        );
        $this->assertStringContainsString('<loc>https://m2b.co.id/blog/artikel-published</loc>', $xml);
        $this->assertStringNotContainsString('artikel-draft', $xml, 'Artikel draft tidak boleh masuk sitemap.');
        $this->assertStringContainsString('<loc>https://m2b.co.id</loc>', $xml, 'Home ditulis tanpa trailing slash.');
        $this->assertStringContainsString('xml-stylesheet', $xml, 'Processing instruction /sitemap.xsl hilang.');
    }

    public function test_sitemap_yang_dihasilkan_adalah_xml_valid(): void
    {
        $this->artikel('artikel-published', 'published');

        $this->artisan('sitemap:generate')->assertSuccessful();

        $xml = simplexml_load_file(public_path('sitemap.xml'));

        $this->assertNotFalse($xml, 'public/sitemap.xml bukan XML yang valid.');
        $this->assertSame('urlset', $xml->getName());
        // 9 halaman statis + 1 artikel uji.
        $this->assertCount(10, $xml->url);
    }

    private function artikel(string $slug, string $status): void
    {
        Post::create([
            'title' => 'Artikel '.$slug,
            'slug' => $slug,
            'excerpt' => 'Ringkasan '.$slug.'.',
            'content' => '<p>'.str_repeat('Konten uji sitemap. ', 40).'</p>',
            'meta_description' => 'Deskripsi '.$slug.'.',
            'category' => 'Ekspor',
            'lang' => 'id',
            'status' => $status,
            'published_at' => $status === 'published' ? now()->subDay() : null,
        ]);
    }
}
