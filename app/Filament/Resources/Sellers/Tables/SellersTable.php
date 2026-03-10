<?php

namespace App\Filament\Resources\Sellers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SellersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role')->searchable(),
                TextColumn::make('no_rekening')->searchable(),
            ])

            ->filters([
                TrashedFilter::make()
                    ->visible(fn () => auth()->user()?->role === 'admin'),
            ])

            ->recordActions([
                ViewAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->role === 'admin'),

                    ForceDeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->role === 'admin'),

                    RestoreBulkAction::make()
                        ->visible(fn () => auth()->user()?->role === 'admin'),
                ]),
            ]);
    }
}