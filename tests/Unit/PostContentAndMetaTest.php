<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;

/**
 * Post::contentHtml() dan Post::metaSnippet() — aturan render yang lahir dari
 * audit SEO m2b.co.id 22 Oktober 2026.
 *
 * contentHtml(): body dari CMS diawali H1 berisi judul artikel, sementara hero
 * halaman sudah merender <h1> judul yang sama → dua H1 per halaman dan judul
 * tercetak dua kali. H1 yang sama dengan judul dibuang; H1 lain diturunkan jadi
 * H2 supaya syarat satu H1 per halaman tetap terpenuhi.
 *
 * metaSnippet(): kolom meta_description dari CMS berisi sampai 185 karakter,
 * sementara Google memangkas deskripsi di ±155 karakter dan potongan mentahnya
 * jatuh di tengah kata.
 */
class PostContentAndMetaTest extends TestCase
{
    public function test_h1_duplikat_judul_dibuang_dari_body(): void
    {
        $post = new Post([
            'title' => 'Cara Impor Sparepart: Panduan Lengkap',
            'content' => '<h1 id="cara-impor-sparepart">Cara Impor Sparepart: Panduan Lengkap</h1><p>Isi artikel.</p>',
        ]);

        $html = $post->contentHtml();

        $this->assertStringNotContainsString('<h1', $html);
        $this->assertStringNotContainsString('id="cara-impor-sparepart"', $html);
        $this->assertStringContainsString('<p>Isi artikel.</p>', $html);
    }

    public function test_perbandingan_judul_tidak_terpengaruh_spasi_entitas_dan_huruf_besar(): void
    {
        $post = new Post([
            'title' => "Panduan Impor & Ekspor",
            'content' => "<h1>\n  panduan impor &amp; ekspor  </h1><p>Isi.</p>",
        ]);

        $this->assertStringNotContainsString('<h1', $post->contentHtml());
    }

    public function test_h1_lain_diturunkan_menjadi_h2_dengan_atribut_utuh(): void
    {
        $post = new Post([
            'title' => 'Judul Artikel',
            'content' => '<h1>Judul Artikel</h1><h1 id="catatan-akhir" class="penting">Catatan Akhir</h1>',
        ]);

        $html = $post->contentHtml();

        $this->assertStringNotContainsString('<h1', $html);
        $this->assertStringContainsString('<h2 id="catatan-akhir" class="penting">Catatan Akhir</h2>', $html);
    }

    public function test_konten_tanpa_h1_dibiarkan_apa_adanya(): void
    {
        $konten = '<h2>Sub</h2><p>Isi artikel tanpa H1.</p>';

        $post = new Post(['title' => 'Judul Artikel', 'content' => $konten]);

        $this->assertSame($konten, $post->contentHtml());
    }

    public function test_meta_snippet_membiarkan_teks_pendek_utuh(): void
    {
        $this->assertSame(
            'Panduan impor sparepart untuk pemula.',
            Post::metaSnippet('Panduan impor sparepart untuk pemula.')
        );
        $this->assertSame('', Post::metaSnippet(null));
    }

    public function test_meta_snippet_membersihkan_tag_entitas_dan_spasi_berlebih(): void
    {
        $this->assertSame(
            'Impor & ekspor sparepart pesawat.',
            Post::metaSnippet("<p>Impor &amp; ekspor\n   sparepart <strong>pesawat</strong>.</p>")
        );
    }

    public function test_meta_snippet_memotong_di_batas_kata_maksimal_155_karakter(): void
    {
        $panjang = str_repeat('panduan impor sparepart pesawat untuk pemula ', 10);

        $hasil = Post::metaSnippet($panjang, 155);
        $potong = rtrim($hasil, '…');

        $this->assertLessThanOrEqual(155, mb_strlen($hasil));
        $this->assertStringEndsWith('…', $hasil);
        // Hasil harus berupa awalan teks asli yang berhenti tepat di batas kata:
        // karakter berikutnya pada teks sumber adalah spasi, bukan potongan kata
        // ("...untuk pemu").
        $this->assertSame(mb_substr($panjang, 0, mb_strlen($potong)), $potong);
        $this->assertSame(' ', mb_substr($panjang, mb_strlen($potong), 1));
    }

    public function test_meta_snippet_memotong_paksa_teks_tanpa_spasi(): void
    {
        $hasil = Post::metaSnippet(str_repeat('a', 300), 100);

        $this->assertSame(100, mb_strlen($hasil), 'Teks tanpa spasi tetap dipotong tepat di batas kuota.');
    }

    public function test_accessor_meta_description_memakai_aturan_yang_sama(): void
    {
        $post = new Post([
            'meta_description' => str_repeat('Deskripsi panjang dari CMS. ', 10),
            'excerpt' => 'Ringkasan pendek.',
        ]);

        $this->assertSame($post->meta_description, Post::metaSnippet($post->getRawOriginal('meta_description') ?? $post->meta_description));
        $this->assertLessThanOrEqual(155, mb_strlen($post->meta_description));

        // Tanpa meta_description → excerpt dipakai, dan bila excerpt juga lebih
        // panjang dari kuota, hasilnya tetap dipotong.
        $tanpaMeta = new Post(['excerpt' => str_repeat('Ringkasan dari excerpt. ', 20)]);
        $this->assertLessThanOrEqual(155, mb_strlen($tanpaMeta->meta_description));
        $this->assertStringStartsWith('Ringkasan dari excerpt.', $tanpaMeta->meta_description);
    }
}
