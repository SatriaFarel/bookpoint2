<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action as ActionsAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Set;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                /* ORDER CODE */

                TextColumn::make('order_code')
                    ->label('Order Code')
                    ->searchable()
                    ->sortable(),
                
                /* ORDER DATE */
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),

                /* CUSTOMER */

                TextColumn::make('customer.name')
                    ->label('Pembeli')
                    ->searchable(),

                /* TOTAL */

                TextColumn::make('total_price')
                    ->label('Total')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state)),

                /* STATUS */

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {

                        'pending' => 'warning',
                        'paid' => 'success',
                        'done' => 'gray',

                        default => 'gray'
                    }),

            ])

            ->actions([

                /* ================= PEMBAYARAN ================= */

                ActionsAction::make('payment')
                    ->label('Pembayaran')
                    ->icon('heroicon-o-credit-card')
                    ->color('success')

                    ->visible(fn($record) => $record->status === 'pending')

                    ->form([

                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'cash' => 'Cash',
                                // 'transfer' => 'Transfer',
                                // 'qris' => 'QRIS',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('paid_amount')
                            ->label('Jumlah Bayar')
                            ->numeric()
                            ->prefix('Rp')
                            ->live(debounce: 300)
                            ->afterStateHydrated(function (Set $set) {
                                $set('change_amount', 0);
                            })
                            ->afterStateUpdated(function ($state, Set $set, $record) {
                                $paid = (float) ($state ?? 0);
                                $total = (float) $record->total_price;
                                $change = $paid - $total;

                                $set('change_amount', $change > 0 ? $change : 0);
                            })
                            ->required(),

                        Forms\Components\TextInput::make('change_amount')
                            ->label('Kembalian')
                            ->prefix('Rp')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(false),

                    ])

                    ->action(function ($record, $data) {

                        $total = $record->total_price;
                        $paid  = (float) $data['paid_amount'];

                        // cek uang cukup
                        if ($paid < $total) {

                            \Filament\Notifications\Notification::make()
                                ->title('Uang tidak cukup')
                                ->danger()
                                ->send();

                            return;
                        }

                        $change = $paid - $total;

                        $record->update([
                            'payment_method' => $data['payment_method'],
                            'paid_amount' => $paid,
                            'status' => 'paid'
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran berhasil')
                            ->body(
                                'Total: Rp ' . number_format($total) .
                                ' | Bayar: Rp ' . number_format($paid) .
                                ' | Kembalian: Rp ' . number_format($change)
                            )
                            ->success()
                            ->send();

                        return redirect('/admin/invoice/' . $record->id);
                    }),

                /* ================= SELESAI ================= */

                ActionsAction::make('done')
                    ->label('Pesanan Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')

                    ->visible(fn($record) => $record->status === 'paid')

                    ->requiresConfirmation()

                    ->action(function ($record) {

                        $record->update([
                            'status' => 'done'
                        ]);
                    }),
                ActionsAction::make('print')
                    ->label('Print Struk')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn($record) => url('/admin/invoice/' . $record->id))
                    ->openUrlInNewTab()
                    ->visible(fn($record) => in_array($record->status, ['paid', 'done'])),

            ]);
    }
}
