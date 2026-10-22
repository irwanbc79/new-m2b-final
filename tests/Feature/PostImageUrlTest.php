<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Post::imageUrl() — satu resolver untuk gambar artikel.
 *
 * Sebelumnya aturan "featured_image → URL" disalin di lima blade (kartu grid,
 * featured, hero artikel, Artikel Terkait, strip blog home) dan sekali lagi di
 * accessor og:image, dengan DUA hasil berbeda untuk berkas yang sama:
 * Storage::url() memakai disk default (`local` di aplikasi ini) sehingga
 * menghasilkan URL relatif `/storage/...`, sementara accessor memakai
 * asset('storage/...') yang absolut.
 *
 * Yang diuji di sini bukan "tampilannya benar" tapi sifat kontraknya: absolut,
 * dinormalkan, dan URL dari luar dipakai apa adanya. Semua ini rusak tanpa
 * error apa pun — kartu tetap ter-render, hanya gambarnya yang tidak muncul
 * (atau muncul hanya di sebagian halaman).
 */
class PostImageUrlTest extends TestCase
{
    public function test_artikel_tanpa_gambar_tidak_punya_url_kartu(): void
    {
        $post = $this->artikel(null);

        $this->assertNull($post->imageUrl(), 'Kartu tanpa gambar harus null supaya blade memakai tema kategori.');
        $this->assertNull($this->artikel('')->imageUrl());
        $this->assertNull($this->artikel('   ')->imageUrl(), 'Berkas terisi spasi tidak boleh jadi url(/storage/).');
    }

    public function test_og_image_tetap_punya_fallback_kartu_sosial(): void
    {
        $this->assertSame(asset('images/og-m2b.jpg'), $this->artikel(null)->featured_image_url);
    }

    public function test_path_relatif_menjadi_url_absolut_lewat_disk_public(): void
    {
        $url = $this->artikel('posts/kartu-uji.jpg')->imageUrl();

        $this->assertSame(Storage::disk('public')->url('posts/kartu-uji.jpg'), $url);
        $this->assertStringStartsWith('http', $url, 'URL relatif (/storage/...) salah untuk og:image dan RSS.');
    }

    public function test_path_dengan_slash_di_depan_dinormalkan(): void
    {
        $this->assertSame(
            Storage::disk('public')->url('posts/kartu-uji.jpg'),
            $this->artikel('/posts/kartu-uji.jpg')->imageUrl()
        );
    }

    public function test_url_absolut_dipakai_apa_adanya(): void
    {
        $this->assertSame('https://cdn.example.com/posts/a.jpg', $this->artikel('https://cdn.example.com/posts/a.jpg')->imageUrl());
    }

    public function test_url_protocol_relative_dan_unicode_tidak_ditempeli_prefix_disk(): void
    {
        // //cdn... ditolak Str::startsWith pada implementasi blade lama, dan URL
        // unicode ditolak filter_var pada implementasi accessor lama — resolver
        // ini harus menangani keduanya.
        $this->assertSame('//cdn.example.com/posts/a.jpg', $this->artikel('//cdn.example.com/posts/a.jpg')->imageUrl());
        $this->assertSame('https://m2b.co.id/gambar/ekspor-ünïcode.jpg', $this->artikel('https://m2b.co.id/gambar/ekspor-ünïcode.jpg')->imageUrl());
    }

    public function test_accessor_og_image_memakai_resolver_yang_sama(): void
    {
        $post = $this->artikel('posts/kartu-uji.jpg');

        $this->assertSame($post->imageUrl(), $post->featured_image_url);
    }

    /**
     * Guard anti-regresi: aturan ini tidak boleh disalin lagi ke blade. Kalau
     * suatu saat ada yang menempelkan Storage::url($post->featured_image) baru,
     * halaman itu langsung kembali memakai URL relatif tanpa error apa pun.
     */
    public function test_tidak_ada_blade_yang_menyalin_aturan_gambar_lagi(): void
    {
        $blade = [
            'components/post-card.blade.php' => 'kartu grid /blog',
            'pages/blog/index.blade.php' => 'kartu featured',
            'pages/blog/show.blade.php' => 'hero artikel + kartu Artikel Terkait',
            'pages/home.blade.php' => 'strip blog di halaman home',
        ];

        foreach ($blade as $relatif => $bagian) {
            $isi = file_get_contents(resource_path("views/{$relatif}"));

            $this->assertSame(
                0,
                preg_match('/Storage::url\(\s*\$[A-Za-z]+\s*->\s*featured_image/', $isi),
                "{$relatif} ({$bagian}) menyimpan salinan resolver gambar sendiri — pakai \$post->imageUrl()."
            );

            $this->assertStringContainsString(
                '->imageUrl()',
                $isi,
                "{$relatif} ({$bagian}) tidak merender gambar artikel lewat \$post->imageUrl()."
            );
        }
    }

    private function artikel(?string $featuredImage): Post
    {
        return new Post(['featured_image' => $featuredImage]);
    }
}
