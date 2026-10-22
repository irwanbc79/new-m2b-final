<?php

namespace App\Console\Commands;

use App\Models\Post;
use DOMDocument;
use DOMElement;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = "sitemap:generate";
    protected $description = "Generate sitemap.xml untuk SEO";

    private const BASE = "https://m2b.co.id";

    /**
     * Halaman statis → [prioritas, changefreq].
     *
     * "/blog/" sengaja ditulis DENGAN trailing slash: /blog (tanpa slash)
     * dijawab edge hCDN dengan 301 → /blog/, dan sitemap tidak boleh memuat URL
     * yang di-redirect (GSC: "URL di sitemap mengarah ke redirect").
     */
    private const HALAMAN_STATIS = [
        "/" => ["1.0", "weekly"],
        "/tentang-kami" => ["0.8", "monthly"],
        "/tim" => ["0.6", "monthly"],
        "/blog/" => ["0.9", "daily"],
        "/blog/kalkulator-bea-masuk" => ["0.8", "monthly"],
        "/karir" => ["0.7", "weekly"],
        "/privacy-policy" => ["0.3", "yearly"],
        "/disclaimer" => ["0.3", "yearly"],
        "/ketentuan-layanan" => ["0.3", "yearly"],
    ];

    /**
     * XML ditulis langsung dengan DOMDocument, bukan spatie/sitemap: paket itu
     * tidak ada di composer.json/composer.lock, sehingga perintah ini berhenti
     * dengan "Class Spatie\Sitemap\Sitemap not found" pada instalasi apa pun
     * hasil composer install (sitemap produksi yang beredar dihasilkan versi
     * lama yang paketnya masih terpasang).
     */
    public function handle(): void
    {
        $xml = new DOMDocument("1.0", "UTF-8");
        $xml->formatOutput = true;

        $urlset = $xml->createElement("urlset");
        $urlset->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
        $xml->appendChild($urlset);

        foreach (self::HALAMAN_STATIS as $path => [$prioritas, $changefreq]) {
            $urlset->appendChild($this->url($xml, $path, null, $prioritas, $changefreq));
        }

        $jumlahPost = 0;
        Post::where("status", "published")
            ->orderByDesc("published_at")
            ->each(function (Post $post) use ($xml, $urlset, &$jumlahPost) {
                $urlset->appendChild($this->url(
                    $xml,
                    "/blog/{$post->slug}",
                    $post->updated_at?->toAtomString(),
                    "0.7",
                    "monthly"
                ));
                $jumlahPost++;
            });

        // Browser menampilkan sitemap bergaya lewat /sitemap.xsl (berkas statis
        // yang sudah ada di public/ server).
        $xml->insertBefore(
            $xml->createProcessingInstruction("xml-stylesheet", 'type="text/xsl" href="/sitemap.xsl"'),
            $xml->documentElement
        );

        $xml->save(public_path("sitemap.xml"));

        $this->info(sprintf(
            "Sitemap generated: %d halaman statis + %d blog posts → public/sitemap.xml",
            count(self::HALAMAN_STATIS),
            $jumlahPost
        ));
    }

    private function url(DOMDocument $xml, string $path, ?string $lastmod, string $prioritas, string $changefreq): DOMElement
    {
        $node = $xml->createElement("url");

        // Nilai teks ditulis lewat createTextNode: createElement("loc", $nilai)
        // tidak meng-escape "&" (slug lama/URL dari CMS bisa memuatnya).
        $this->teks($xml, $node, "loc", self::BASE . ($path === "/" ? "" : $path));

        if ($lastmod !== null) {
            $this->teks($xml, $node, "lastmod", $lastmod);
        }

        $this->teks($xml, $node, "changefreq", $changefreq);
        $this->teks($xml, $node, "priority", $prioritas);

        return $node;
    }

    private function teks(DOMDocument $xml, DOMElement $parent, string $nama, string $nilai): void
    {
        $parent->appendChild($xml->createElement($nama))->appendChild($xml->createTextNode($nilai));
    }
}
