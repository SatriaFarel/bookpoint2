<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Categories', \App\Models\Category::count()),
            Stat::make('Total Customers', \App\Models\User::customer()->count()),    
            Stat::make('Total Products', \App\Models\Product::count()),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}
