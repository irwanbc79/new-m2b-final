<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share news ticker data across the layouts.app view
        view()->composer('layouts.app', function ($view) {
            $tickerItems = Cache::remember('running_ticker_news', 1800, function () {
                $ebookItems = [
                    ['📘 E-Book Ekspor Impor Premium & Download TOOLKIT GRATIS di ebook.m2b.co.id', 'https://ebook.m2b.co.id', true],
                    ['📘 Download Toolkit Ekspor Impor GRATIS & Panduan Lengkap E-Book di ebook.m2b.co.id', 'https://ebook.m2b.co.id', true]
                ];

                $newsItems = [];
                try {
                    $url = 'https://news.google.com/rss/search?q=ekspor+impor+bea+cukai+UMKM+logistik+pajak&hl=id&gl=ID&ceid=ID:id';
                    $options = [
                        'http' => [
                            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.0.0 Safari/537.36\r\n"
                        ]
                    ];
                    $context = stream_context_create($options);
                    $xmlString = @file_get_contents($url, false, $context);
                    if ($xmlString) {
                        $xml = simplexml_load_string($xmlString);
                        if ($xml && isset($xml->channel->item)) {
                            $count = 0;
                            foreach ($xml->channel->item as $item) {
                                $title = (string) $item->title;
                                $link = (string) $item->link;
                                
                                // Clean publisher suffix from title (e.g. " - Kompas.com")
                                $lastDash = strrpos($title, ' - ');
                                if ($lastDash !== false) {
                                    $title = substr($title, 0, $lastDash);
                                }
                                
                                $newsItems[] = ["📰 " . $title, $link, false];
                                $count++;
                                if ($count >= 10) {
                                    break;
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Fail silently, fallback to static news below
                }

                if (empty($newsItems)) {
                    $newsItems = [
                        ['⚖️ Bea Cukai RI: Update Regulasi Lartas & Ketentuan Ekspor-Impor Terbaru', 'https://www.beacukai.go.id', false],
                        ['📈 Kemenkeu RI: PMK Penyesuaian Tarif Bea Masuk & PPN Jasa Ekspor-Impor', 'https://fiskal.kemenkeu.go.id', false],
                        ['🛳️ Pelindo: Info Konektivitas Logistik di Pelabuhan Tanjung Priok & Belawan', 'https://www.pelindo.co.id', false],
                        ['📋 LNSW: Integrasi Sistem Dokumen Ekspor-Impor via Portal INSW', 'https://www.insw.go.id', false],
                        ['💼 DJP Pajak: Pajak Pertambahan Nilai (PPN) Terkait Jasa Logistik Ekspor', 'https://www.pajak.go.id', false],
                        ['🌐 Kemendag RI: Kebijakan Fasilitasi Perdagangan Internasional & Ekspor Non-Migas', 'https://www.kemendag.go.id', false],
                        ['🚀 Bea Cukai & Kemenkop UKM: Kolaborasi Dorong UMKM Nasional Go-Export Tembus Pasar Global', 'https://www.beacukai.go.id', false],
                        ['📦 Program Klinik Ekspor: Asistensi Prosedur Bea Cukai & Rantai Pasok Global Bagi Pelaku UMKM', 'https://www.kemendag.go.id', false],
                        ['⚓ The Loadstar: Supply chain disruptions & global ocean freight rates', 'https://theloadstar.com', false],
                        ['🚢 JOC.com: Container shipping industry news & global port congestion status', 'https://www.joc.com', false]
                    ];
                }

                $combined = array_merge($ebookItems, $newsItems);
                // Double the list to support seamless marquee loop animation
                return array_merge($combined, $combined);
            });

            $view->with('tickerItems', $tickerItems);
        });
    }
}
