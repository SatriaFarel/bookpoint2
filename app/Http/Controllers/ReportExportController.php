<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;

class ReportExportController extends Controller
{
    private function buildDoneOrderQuery(Request $request)
    {
        $sellerId = Auth::id();

        $query = DB::table('orders')
            ->where('seller_id', $sellerId)
            ->where('status', 'done');

        if ($request->filled('month')) {
            $query->whereMonth('created_at', (int) $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', (int) $request->year);
        }

        return $query;
    }

    private function buildDoneOrderItemsQuery(Request $request)
    {
        $sellerId = Auth::id();

        $query = DB::table('order_items as oi')
            ->join('orders as o', 'o.id', '=', 'oi.order_id')
            ->leftJoin('products as p', 'p.id', '=', 'oi.product_id')
            ->leftJoin('users as seller', 'seller.id', '=', 'o.seller_id')
            ->leftJoin('users as customer', 'customer.id', '=', 'o.customer_id')
            ->where('o.seller_id', $sellerId)
            ->where('o.status', 'done');

        if ($request->filled('month')) {
            $query->whereMonth('o.created_at', (int) $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('o.created_at', (int) $request->year);
        }

        return $query;
    }

    public function pdf(Request $request)
    {
        $reports = $this->buildDoneOrderQuery($request)
            ->select(
                'order_code',
                DB::raw('DATE(created_at) as date'),
                'total_price',
                'status'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        $total = (float) $reports->sum('total_price');

        return response()
            ->view('filament.pages.report-pdf', [
                'reports' => $reports,
                'total' => $total,
                'filterMonth' => $request->month,
                'filterYear' => $request->year,
            ]);
    }

    public function excel(Request $request)
    {
        $rows = $this->buildDoneOrderItemsQuery($request)
            ->select(
                'oi.id as order_item_id',
                'oi.order_id',
                'oi.product_id',
                'oi.quantity',
                'oi.price as item_price',
                DB::raw('(oi.quantity * oi.price) as item_subtotal'),
                'o.order_code',
                'seller.name as seller_name',
                'customer.name as customer_name',
                DB::raw('DATE(o.created_at) as order_date'),
                'o.total_price as order_total',
                'o.payment_method',
                'o.paid_amount',
                'o.status',
                'p.name as product_name'
            )
            ->orderBy('o.created_at', 'desc')
            ->orderBy('oi.id')
            ->get();

        $grandTotal = (float) $rows->sum('item_subtotal');

        $dir = storage_path('app/temp');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $filename = 'laporan-penjualan-' . now()->format('Ymd-His') . '.xlsx';
        $path = $dir . DIRECTORY_SEPARATOR . $filename;

        $writer = new Writer();
        $writer->getOptions()->setColumnWidth(8, 1);
        $writer->getOptions()->setColumnWidth(14, 2, 3, 4, 10, 12, 13);
        $writer->getOptions()->setColumnWidth(20, 5, 6, 8, 9, 11);
        $writer->getOptions()->setColumnWidth(26, 7, 14, 15);
        $writer->openToFile($path);

        $thinBorder = new Border(
            new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
        );

        $titleStyle = (new Style())
            ->setFontBold()
            ->setFontSize(14);

        $metaStyle = (new Style())
            ->setFontSize(10)
            ->setFontColor(Color::rgb(71, 85, 105));

        $headerStyle = (new Style())
            ->setFontBold()
            ->setFontSize(11)
            ->setBackgroundColor(Color::rgb(226, 232, 240))
            ->setBorder($thinBorder);

        $bodyStyle = (new Style())
            ->setFontSize(10)
            ->setBorder($thinBorder);

        $moneyStyle = (new Style())
            ->setFontSize(10)
            ->setCellAlignment(\OpenSpout\Common\Entity\Style\CellAlignment::RIGHT)
            ->setFormat('#,##0')
            ->setBorder($thinBorder);

        $totalStyle = (new Style())
            ->setFontBold()
            ->setBackgroundColor(Color::rgb(241, 245, 249))
            ->setBorder($thinBorder);

        $writer->addRow(Row::fromValues(['LAPORAN BOOK STORE'], $titleStyle));
        $writer->addRow(Row::fromValues(['Tanggal Report: ' . now()->format('d M Y H:i')], $metaStyle));
        $writer->addRow(Row::fromValues([
            'Filter: '
            . ($request->filled('month') ? 'Bulan ' . $request->month : 'Semua Bulan')
            . ' / '
            . ($request->filled('year') ? 'Tahun ' . $request->year : 'Semua Tahun')
        ], $metaStyle));
        $writer->addRow(Row::fromValues([]));

        $writer->addRow(Row::fromValues([
            'No',
            'Order Item ID',
            'Order ID',
            'Order Code',
            'Tanggal Order',
            'Status',
            'Seller',
            'Customer',
            'Product ID',
            'Nama Produk',
            'Qty',
            'Harga Item',
            'Subtotal Item',
            'Total Order',
            'Payment Method',
            'Paid Amount',
        ], $headerStyle));

        foreach ($rows as $index => $row) {
            $writer->addRow(Row::fromValuesWithStyles([
                $index + 1,
                $row->order_item_id,
                $row->order_id,
                $row->order_code,
                $row->order_date,
                strtoupper((string) $row->status),
                $row->seller_name ?? '-',
                $row->customer_name ?? '-',
                $row->product_id,
                $row->product_name ?? '-',
                (int) $row->quantity,
                (float) $row->item_price,
                (float) $row->item_subtotal,
                (float) $row->order_total,
                strtoupper((string) ($row->payment_method ?? '-')),
                (float) ($row->paid_amount ?? 0),
            ], $bodyStyle, [
                11 => $moneyStyle,
                12 => $moneyStyle,
                13 => $moneyStyle,
                15 => $moneyStyle,
            ]));
        }

        $writer->addRow(Row::fromValuesWithStyles([
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'GRAND TOTAL',
            '',
            '',
            (float) $grandTotal,
            '',
            '',
            '',
        ], $totalStyle, [
            12 => $moneyStyle,
        ]));

        $writer->close();

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }
}
