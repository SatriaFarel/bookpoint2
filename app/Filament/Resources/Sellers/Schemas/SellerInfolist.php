<?php

namespace App\Filament\Resources\Sellers\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
class SellerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Seller')
                    ->schema([

                        ImageEntry::make('image')
                            ->label('Foto Profil')
                            ->disk('public')
                            ->circular()
                            ->size(120),

                        TextEntry::make('name')
                            ->label('Nama')
                            ->weight('bold'),

                        TextEntry::make('email')
                            ->label('Email'),

                        TextEntry::make('nik')
                            ->label('NIK'),

                        TextEntry::make('no_rekening')
                            ->label('No Rekening'),

                        TextEntry::make('role')
                            ->label('Role')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'admin' => 'danger',
                                'seller' => 'success',
                                'customer' => 'info',
                                default => 'gray',
                            }),

                    ])
                    ->columns(2),

            ]);
    }
}