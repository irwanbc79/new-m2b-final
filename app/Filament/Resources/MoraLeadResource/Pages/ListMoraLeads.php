<?php

namespace App\Filament\Resources\MoraLeadResource\Pages;

use App\Filament\Resources\MoraLeadResource;
use App\Filament\Widgets\MoraLeadStatsWidget;
use Filament\Resources\Pages\ListRecords;

class ListMoraLeads extends ListRecords
{
    protected static string $resource = MoraLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [MoraLeadStatsWidget::class];
    }
}
