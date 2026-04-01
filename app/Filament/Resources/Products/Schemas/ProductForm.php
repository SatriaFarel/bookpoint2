<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\Category;
use Filament\Forms\Components\Hidden;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('seller_id')
                //     ->required()
                //     ->numeric(),

                Hidden::make('seller_id')
                    ->default(auth()->id())
                    ->required(),
                
                Select::make('category_id')
                    ->label('Category')
                    ->options(fn () => Category::query()->orderBy('name')->pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->unique(table: 'category', column: 'name'),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        return Category::create([
                            'name' => $data['name'],
                        ])->id;
                    })
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('description')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Ro'),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    
                    ->visibility('public')
                    ->nullable()
            ]);
    }
}
