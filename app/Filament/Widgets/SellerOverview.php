<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SellerOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', \App\Models\Product::count()),
        ];
    }
    
    public static function canView(): bool
    {
        return auth()->user()?->role === 'seller';
    }
}
