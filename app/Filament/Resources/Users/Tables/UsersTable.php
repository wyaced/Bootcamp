<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                CheckboxColumn::make('is_muted')
                    ->disabled(fn(User $user) => $user->hasRole('admin'))
                    ->label('Is Muted'),
                TextColumn::make('role')
                    ->label('Role')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->disabled(fn(User $user) => $user->id !== Auth::user()->id),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('mute')
                        ->label('Mute')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records
                                ->filter(fn (User $user) => $user->hasRole('admin') === false)
                                ->each->update(['is_muted' => true]);
                        })
                        ->color('warning')
                        ->icon('heroicon-m-speaker-x-mark')
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unmute')
                        ->label('Unmute')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records
                                ->filter(fn (User $user) => $user->hasRole('admin') === false)
                                ->each->update(['is_muted' => false]);
                        })
                        ->color('success')
                        ->icon('heroicon-m-speaker-wave')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
