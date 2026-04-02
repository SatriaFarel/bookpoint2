<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Livewire\WithPagination;

class Report extends Page
{
    use WithPagination;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected string $view = 'filament.pages.report';
    protected static ?string $title = 'Laporan Penjualan';

     protected static ?int $navigationSort = 90;


    public $filterMonth;
    public $filterYear;
    public int $perPage = 10;

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

    private function buildDoneOrderQuery()
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

        return $query;
    }

    public function getPrintReports()
    {
        return $this->buildDoneOrderQuery()
            ->select(
                'order_code',
                DB::raw('DATE(created_at) as date'),
                'total_price',
                'status'
            )
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function getPrintReportsForExport()
    {
        return $this->buildDoneOrderQuery()
            ->select(
                'order_code',
                DB::raw('DATE(created_at) as date'),
                'total_price',
                'status'
            )
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTotalDoneSales(): float
    {
        return (float) $this->buildDoneOrderQuery()->sum('total_price');
    }

    public function updatedFilterMonth(): void
    {
        $this->resetPage();
    }

    public function updatedFilterYear(): void
    {
        $this->resetPage();
    }
}
