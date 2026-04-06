<?php

namespace App\Filament\Resources\ChirpLogs\Pages;

use App\Filament\Resources\ChirpLogs\ChirpLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChirpLogs extends ListRecords
{
    protected static string $resource = ChirpLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
