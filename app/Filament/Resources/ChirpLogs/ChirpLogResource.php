<?php

namespace App\Filament\Resources\ChirpLogs;

use App\Filament\Resources\ChirpLogs\Pages\CreateChirpLog;
use App\Filament\Resources\ChirpLogs\Pages\EditChirpLog;
use App\Filament\Resources\ChirpLogs\Pages\ListChirpLogs;
use App\Filament\Resources\ChirpLogs\Pages\ViewChirpLog;
use App\Filament\Resources\ChirpLogs\Schemas\ChirpLogForm;
use App\Filament\Resources\ChirpLogs\Schemas\ChirpLogInfolist;
use App\Filament\Resources\ChirpLogs\Tables\ChirpLogsTable;
use App\Models\ChirpLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChirpLogResource extends Resource
{
    protected static ?string $model = ChirpLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleBottomCenterText;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ChirpLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ChirpLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChirpLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChirpLogs::route('/'),
            'create' => CreateChirpLog::route('/create'),
            'view' => ViewChirpLog::route('/{record}'),
            'edit' => EditChirpLog::route('/{record}/edit'),
        ];
    }
}
