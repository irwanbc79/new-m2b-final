<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh exchange rates from Kemenkeu and Bank Indonesia';

    /**
     * Execute the console command.
     */
    public function handle(ExchangeRateService $rateService): void
    {
        $this->info('Starting exchange rates refresh...');
        Log::info('ExchangeRateCommand: Starting refresh...');

        try {
            $rates = $rateService->refreshRates();
            
            $this->info('Exchange rates refreshed successfully.');
            $this->info('Kurs Pajak USD: Rp ' . number_format($rates['pajak']['rates']['USD'] ?? 0, 2, ',', '.'));
            $this->info('Kurs BI USD: Rp ' . number_format($rates['bi']['rates']['USD'] ?? 0, 2, ',', '.'));
            
            Log::info('ExchangeRateCommand: Refreshed successfully.', [
                'pajak_usd' => $rates['pajak']['rates']['USD'] ?? null,
                'bi_usd' => $rates['bi']['rates']['USD'] ?? null,
            ]);
        } catch (\Exception $e) {
            $this->error('Failed to refresh exchange rates: ' . $e->getMessage());
            Log::error('ExchangeRateCommand: Failed to refresh: ' . $e->getMessage());
        }
    }
}
