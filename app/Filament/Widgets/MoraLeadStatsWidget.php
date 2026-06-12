<?php

namespace App\Filament\Widgets;

use App\Models\MoraLead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MoraLeadStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $total      = MoraLead::count();
        $newLeads   = MoraLead::where('status', 'new')->count();
        $hotLeads   = MoraLead::where('score', 'hot')->whereNotIn('status', ['converted', 'lost'])->count();
        $converted  = MoraLead::where('status', 'converted')->count();
        $thisMonth  = MoraLead::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $overdue    = MoraLead::whereNotNull('follow_up_at')
                        ->where('follow_up_at', '<', now())
                        ->whereNotIn('status', ['converted', 'lost'])
                        ->count();

        $convRate = $total > 0 ? round($converted / $total * 100, 1) : 0;

        return [
            Stat::make('Lead Baru', $newLeads)
                ->description('Belum ditindaklanjuti')
                ->descriptionIcon('heroicon-m-inbox')
                ->color($newLeads > 0 ? 'danger' : 'success'),

            Stat::make('🔥 Hot Lead', $hotLeads)
                ->description('Perlu segera dihubungi')
                ->descriptionIcon('heroicon-m-fire')
                ->color('warning'),

            Stat::make('Bulan Ini', $thisMonth)
                ->description('Total lead ' . now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('Konversi', "{$converted} / {$total}")
                ->description("Rate: {$convRate}%")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($convRate >= 20 ? 'success' : 'gray'),

            Stat::make('Follow-up Overdue', $overdue)
                ->description('Jadwal terlewat')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($overdue > 0 ? 'danger' : 'success'),
        ];
    }
}
