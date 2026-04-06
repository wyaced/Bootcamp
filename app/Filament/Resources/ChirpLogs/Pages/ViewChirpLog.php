<?php

namespace App\Filament\Resources\ChirpLogs\Pages;

use App\Filament\Resources\ChirpLogs\ChirpLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewChirpLog extends ViewRecord
{
    protected static string $resource = ChirpLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
