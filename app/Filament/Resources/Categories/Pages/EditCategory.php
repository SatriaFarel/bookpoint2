<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\Product;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [

            DeleteAction::make()
                ->before(function ($record) {

                    $productCount = Product::where('category_id', $record->id)->count();

                    if ($productCount > 0) {

                        Notification::make()
                            ->title('Kategori tidak bisa dihapus')
                            ->body('Masih ada produk yang menggunakan kategori ini.')
                            ->danger()
                            ->send();

                        $this->halt();
                    }
                }),

            ForceDeleteAction::make(),

            RestoreAction::make(),

        ];
    }
}
