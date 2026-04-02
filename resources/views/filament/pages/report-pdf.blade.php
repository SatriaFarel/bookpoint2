<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #111827; }
        .head { margin-bottom: 16px; }
        .muted { color: #6b7280; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; }
        th { background: #f3f4f6; text-align: left; }
        .right { text-align: right; }
        .center { text-align: center; }
        .total { font-weight: 700; background: #f9fafb; }
    </style>
</head>
<body>
    <div class="head">
        <h2 style="margin:0;">Laporan Penjualan</h2>
        <p class="muted" style="margin:4px 0 0 0;">
            Dicetak: {{ now()->format('d M Y H:i') }}
            @if($filterMonth || $filterYear)
                | Filter: {{ $filterMonth ?: 'Semua Bulan' }} / {{ $filterYear ?: 'Semua Tahun' }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:56px;">No</th>
                <th>Order Code</th>
                <th style="width:140px;">Tanggal</th>
                <th style="width:160px;" class="right">Total</th>
                <th style="width:120px;" class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->order_code }}</td>
                    <td>{{ $row->date }}</td>
                    <td class="right">Rp {{ number_format($row->total_price) }}</td>
                    <td class="center">{{ strtoupper($row->status) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" class="right">Total Penjualan</td>
                <td class="right">Rp {{ number_format($total) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <script>
        window.addEventListener('load', () => {
            window.print();
        });
    </script>
</body>
</html>
