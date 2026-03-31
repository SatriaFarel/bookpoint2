<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdminOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', \App\Models\Order::count()),
            Stat::make('Total Customers', \App\Models\User::customer()->count()),
            Stat::make('Total Products', \App\Models\Product::where('seller_id', Auth::id())->count()),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->role === 'admin';
    }
}