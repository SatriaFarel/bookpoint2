<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Report extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected string $view = 'filament.pages.report';
    protected static ?string $title = 'Laporan Penjualan';

     protected static ?int $navigationSort = 90;


    public $filterMonth;
    public $filterYear;

    /* ================= TABLE ================= */

    public function getReports()
    {
        $sellerId = Auth::id();

        $query = DB::table('orders')
            ->where('seller_id', $sellerId);

        if ($this->filterMonth) {
            $query->whereMonth('created_at', $this->filterMonth);
        }

        if ($this->filterYear) {
            $query->whereYear('created_at', $this->filterYear);
        }

        return $query
            ->select(
                'id',
                DB::raw('DATE(created_at) as date'),
                'total_price',
                'status'
            )
            ->latest()
            ->get();
    }

    /* ================= CHART ================= */

    public function getChartData()
    {
        $sellerId = Auth::id();

        $query = DB::table('orders')
            ->where('seller_id', $sellerId);

        if ($this->filterMonth) {
            $query->whereMonth('created_at', $this->filterMonth);
        }

        if ($this->filterYear) {
            $query->whereYear('created_at', $this->filterYear);
        }

        return $query
            ->select(
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month"),
                DB::raw("SUM(total_price) as profit")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function getPrintReports()
    {
        $sellerId = Auth::id();

        $query = DB::table('orders')
            ->where('seller_id', $sellerId)
            ->where('status', 'done');

        if ($this->filterMonth) {
            $query->whereMonth('created_at', $this->filterMonth);
        }

        if ($this->filterYear) {
            $query->whereYear('created_at', $this->filterYear);
        }

        return $query
            ->select(
                'order_code',
                DB::raw('DATE(created_at) as date'),
                'total_price',
                'status'
            )
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
