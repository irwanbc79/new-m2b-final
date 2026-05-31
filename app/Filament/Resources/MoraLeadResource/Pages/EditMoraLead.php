<?php

namespace App\Filament\Resources\MoraLeadResource\Pages;

use App\Filament\Resources\MoraLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMoraLead extends EditRecord
{
    protected static string $resource = MoraLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
