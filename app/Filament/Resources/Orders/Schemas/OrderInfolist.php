<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('seller_id')
                    ->numeric(),
                TextEntry::make('customer_id')
                    ->numeric(),
                TextEntry::make('payment_method'),
                TextEntry::make('paid_amount')
                    ->label('Uang Bayar')
                    ->money('IDR'),
                TextEntry::make('change_amount')
                    ->label('Kembalian')
                    ->state(function (Order $record): float {
                        return max(0, (float) $record->paid_amount - (float) $record->total_price);
                    })
                    ->money('IDR'),
                TextEntry::make('payment_proof')
                    ->placeholder('-'),
                TextEntry::make('total_price')
                    ->money(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('resi')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Order $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
