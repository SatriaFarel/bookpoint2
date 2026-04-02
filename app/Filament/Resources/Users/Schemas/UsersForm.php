<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                fileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('profile-photos')
                    ->visibility('public'),
                // TextInput::make('nik')
                //     ->required()
                //     ->maxLength(16)
                //     ->unique(ignoreRecord: true),
                textInput::make('name')
                    ->required(),
                textInput::make('email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),
                textInput::make('password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->visible(fn (string $operation): bool => $operation === 'create'),
                // textInput::make('no_rekening')
                //     ->required(),
                Hidden::make('role')
                    ->default('customer')
                    ->required(),
            ]);
    }
}
