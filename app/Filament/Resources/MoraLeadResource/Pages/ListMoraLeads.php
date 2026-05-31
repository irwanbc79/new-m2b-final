<?php

namespace App\Filament\Resources\MoraLeadResource\Pages;

use App\Filament\Resources\MoraLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMoraLeads extends ListRecords
{
    protected static string $resource = MoraLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
