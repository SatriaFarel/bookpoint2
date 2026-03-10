<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                fileUpload::make('image')
                    ->image()
                    ->directory('seller-images')
                    ->visibility('public'),
                TextInput::make('nik')
                    ->required()
                    ->maxLength(16)
                    ->unique(ignoreRecord: true),
                textInput::make('name')
                    ->required(),
                textInput::make('email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),
                textInput::make('password')
                    ->required()
                    ->password(),
                textInput::make('no_rekening')
                    ->required(),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'seller' => 'Seller',
                        'customer' => 'Customer',
                    ])
                    ->required()
                    ->native(false),
            ]);
    }
}
