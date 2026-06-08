<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    private const CACHE_KEY = 'mora_exchange_rates';
    private const CACHE_TTL = 43200; // 12 hours in seconds

    /**
     * Get the current exchange rates (cached or fresh).
     */
    public function getRates(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            try {
                return $this->fetchRates();
            } catch (\Exception $e) {
                Log::error('Failed to fetch exchange rates: ' . $e->getMessage());
                return $this->getDefaultRates();
            }
        });
    }

    /**
     * Force refresh the cached rates.
     */
    public function refreshRates(): array
    {
        try {
            $rates = $this->fetchRates();
            Cache::put(self::CACHE_KEY, $rates, self::CACHE_TTL);
            return $rates;
        } catch (\Exception $e) {
            Log::error('Failed to refresh exchange rates: ' . $e->getMessage());
            return $this->getRates(); // Return whatever is currently in cache
        }
    }

    /**
     * Fetch fresh rates from Kemenkeu and BI.
     */
    private function fetchRates(): array
    {
        // Use existing cached rates as base, or defaults if not present
        $rates = Cache::get(self::CACHE_KEY) ?: $this->getDefaultRates();

        // 1. Fetch Kurs Pajak (Kemenkeu)
        try {
            $pajakResponse = Http::timeout(10)->get('https://fiskal.kemenkeu.go.id/informasi-publik/kurs-pajak');
            if ($pajakResponse->successful()) {
                $html = $pajakResponse->body();
                
                // Extract KMK
                if (preg_match('/KMK Nomor ([^<]+)<\/strong>/', $html, $m)) {
                    $rates['pajak']['kmk'] = trim($m[1]);
                }
                
                // Extract Period
                if (preg_match('/Tanggal berlaku:\s*([^<]+)<\/em>/', $html, $m)) {
                    $rates['pajak']['period'] = str_replace(' Juni ', ' Jun ', trim($m[1]));
                }
                
                // Extract USD
                if (preg_match('/Dolar Amerika Serikat \(USD\).*?class="m-l-5">([^<]+)<\/div>/s', $html, $m)) {
                    $rates['pajak']['rates']['USD'] = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                }
                
                // Extract SGD
                if (preg_match('/Dolar Singapura \(SGD\).*?class="m-l-5">([^<]+)<\/div>/s', $html, $m)) {
                    $rates['pajak']['rates']['SGD'] = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                }
                
                // Extract EUR
                if (preg_match('/Euro Euro \(EUR\).*?class="m-l-5">([^<]+)<\/div>/s', $html, $m)) {
                    $rates['pajak']['rates']['EUR'] = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                }
                
                // Extract CNY
                if (preg_match('/Yuan Renminbi Tiongkok \(CNY\).*?class="m-l-5">([^<]+)<\/div>/s', $html, $m)) {
                    $rates['pajak']['rates']['CNY'] = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to scrape Kurs Pajak: ' . $e->getMessage());
        }

        // 2. Fetch Kurs JISDOR USD (BI)
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
        try {
            $jisdorResponse = Http::timeout(10)
                ->withHeaders(['User-Agent' => $userAgent])
                ->get('https://www.bi.go.id/id/statistik/informasi-kurs/jisdor/default.aspx');
            
            if ($jisdorResponse->successful()) {
                $html = $jisdorResponse->body();
                if (preg_match('/<tbody>\s*<tr>\s*<td class="text-center">([^<]+)<\/td>\s*<td class="text-center">Rp([^<]+)<\/td>/s', $html, $m)) {
                    $rates['bi']['rates']['USD'] = (float) str_replace(['.', ','], ['', '.'], trim($m[2]));
                    $rates['bi']['updated_at'] = trim($m[1]);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to scrape BI JISDOR: ' . $e->getMessage());
        }

        // 3. Fetch Kurs Transaksi BI for SGD, EUR, CNY
        try {
            $transaksiResponse = Http::timeout(10)
                ->withHeaders(['User-Agent' => $userAgent])
                ->get('https://www.bi.go.id/id/statistik/informasi-kurs/transaksi-bi/default.aspx');
            
            if ($transaksiResponse->successful()) {
                $html = $transaksiResponse->body();
                
                // Parse SGD
                if (preg_match('/<td class="text-right">SGD\s*<\/td>\s*<td class="text-right">([^<]+)<\/td>\s*<td class="text-right">([^<]+)<\/td>\s*<td class="text-right">([^<]+)<\/td>/s', $html, $m)) {
                    $multiplier = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                    $jual = (float) str_replace(['.', ','], ['', '.'], trim($m[2]));
                    $beli = (float) str_replace(['.', ','], ['', '.'], trim($m[3]));
                    $rates['bi']['rates']['SGD'] = ($jual + $beli) / (2 * $multiplier);
                }
                
                // Parse EUR
                if (preg_match('/<td class="text-right">EUR\s*<\/td>\s*<td class="text-right">([^<]+)<\/td>\s*<td class="text-right">([^<]+)<\/td>\s*<td class="text-right">([^<]+)<\/td>/s', $html, $m)) {
                    $multiplier = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                    $jual = (float) str_replace(['.', ','], ['', '.'], trim($m[2]));
                    $beli = (float) str_replace(['.', ','], ['', '.'], trim($m[3]));
                    $rates['bi']['rates']['EUR'] = ($jual + $beli) / (2 * $multiplier);
                }
                
                // Parse CNY
                if (preg_match('/<td class="text-right">CNY\s*<\/td>\s*<td class="text-right">([^<]+)<\/td>\s*<td class="text-right">([^<]+)<\/td>\s*<td class="text-right">([^<]+)<\/td>/s', $html, $m)) {
                    $multiplier = (float) str_replace(['.', ','], ['', '.'], trim($m[1]));
                    $jual = (float) str_replace(['.', ','], ['', '.'], trim($m[2]));
                    $beli = (float) str_replace(['.', ','], ['', '.'], trim($m[3]));
                    $rates['bi']['rates']['CNY'] = ($jual + $beli) / (2 * $multiplier);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to scrape BI Transaksi rates: ' . $e->getMessage());
        }

        return $rates;
    }

    /**
     * Safe fallback rates if everything is offline.
     */
    private function getDefaultRates(): array
    {
        return [
            'pajak' => [
                'period' => '03 Jun - 09 Jun 2026',
                'kmk' => '25/MK/EF.2/2026',
                'rates' => [
                    'USD' => 17805.00,
                    'SGD' => 13944.36,
                    'EUR' => 20728.94,
                    'CNY' => 2627.25,
                ]
            ],
            'bi' => [
                'updated_at' => '08 Jun 2026',
                'rates' => [
                    'USD' => 18039.00,
                    'SGD' => 13340.00,
                    'EUR' => 19320.00,
                    'CNY' => 2480.00,
                ]
            ]
        ];
    }
}
