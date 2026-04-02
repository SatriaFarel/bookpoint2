<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('scan_order_camera')
                ->label('Scan Kamera')
                ->icon('heroicon-o-qr-code')
                ->color('gray')
                ->url(route('admin.orders.scan')),
        ];
    }
}
