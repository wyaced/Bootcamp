<?php

namespace App\Filament\Resources\ChirpLogs\Tables;

use App\Models\Chirp;
use App\Models\ChirpLog;
use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChirpLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('chirp_id')
                    ->label('Chirp ID')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Message')
                    ->searchable(),
                CheckboxColumn::make('chirp.is_redacted')
                    ->label('Redacted')
                    ->disabled(fn (ChirpLog $log) => $log->chirp->is_deleted),
                CheckboxColumn::make('chirp.is_deleted')
                    ->label('Deleted')
                    ->disabled(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'current' => 'success',
                        'old' => 'gray',
                        'deleted' => 'danger',
                        default => 'secondary',
                    })
                    ->searchable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Filter::make('current_chirps')
                    ->label('Current Chirps')
                    ->query(fn (Builder $query) => $query->whereIn('status', ['current', 'deleted'])),
                Filter::make('deleted_chirps')
                    ->label('Deleted Chirps')
                    ->query(fn (Builder $query) => $query->where('status', 'deleted')),
                Filter::make('redacted_chirps')
                    ->label('Redacted Chirps')
                    ->query(fn (Builder $query) => $query->whereRelation('chirp', 'is_redacted', true)),
                Filter::make('active_chirps')
                    ->label('Active Chirps')
                    ->query(fn (Builder $query) => $query->whereRelation('chirp', 'is_redacted', false)->whereRelation('chirp', 'is_deleted', false)),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
