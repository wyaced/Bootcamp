<?php

namespace App\Filament\Resources\ChirpLogs\Pages;

use App\Filament\Resources\ChirpLogs\ChirpLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditChirpLog extends EditRecord
{
    protected static string $resource = ChirpLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
