@extends('layouts.app1')

@section('content')
<style>
    .invoice-paper {
        font-family: monospace;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        body {
            background: white !important;
        }

        .invoice-shell {
            padding: 0 !important;
            background: white !important;
        }

        .invoice-paper {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
        }
    }
</style>

<div class="invoice-shell min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/40 to-emerald-50/30 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="no-print flex items-center justify-between gap-4 mb-6">
            <div>
                <p class="text-sm text-slate-500">{{ $invoiceTitle }}</p>
                <h1 class="text-2xl font-bold text-slate-800">{{ $order->order_code }}</h1>
            </div>

            <div class="flex gap-3">
                <a href="{{ $backUrl }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                    {{ $backLabel }}
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    Print Invoice
                </button>
            </div>
        </div>

        <div class="invoice-paper bg-white max-w-md mx-auto border border-slate-200 rounded-2xl shadow-xl p-6">
            <div class="text-center">
                <h2 class="font-bold text-lg">BOOKSTORE</h2>
                <p class="text-xs">{{ $order->order_code }}</p>
                <p class="text-xs">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>

            <hr class="my-3">

            <div class="text-xs space-y-1">
                <p>Seller : {{ $order->seller->name ?? 'Admin' }}</p>
                <p>Customer : {{ $order->customer->name }}</p>
                <p>Status : {{ ucfirst($order->status) }}</p>
                @if($order->resi)
                    <p>Resi : {{ $order->resi }}</p>
                @endif
            </div>

            <hr class="my-3">

            <div class="space-y-2 text-sm">
                @foreach($order->items as $item)
                    <div>
                        <div class="flex justify-between gap-4">
                            <span>{{ $item->product->name }}</span>
                            <span>Rp {{ number_format($item->price) }}</span>
                        </div>

                        <div class="flex justify-between text-xs text-gray-500">
                            <span>x{{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->price * $item->quantity) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="my-3">

            <div class="text-sm space-y-1">
                <div class="flex justify-between">
                    <span>Total</span>
                    <span class="font-bold">Rp {{ number_format($order->total_price) }}</span>
                </div>

                @if($order->payment_method)
                    <div class="flex justify-between text-xs">
                        <span>Payment</span>
                        <span>{{ strtoupper($order->payment_method) }}</span>
                    </div>
                @endif

                @if(!is_null($order->paid_amount))
                    <div class="flex justify-between text-xs">
                        <span>Uang Bayar</span>
                        <span>Rp {{ number_format($order->paid_amount) }}</span>
                    </div>

                    <div class="flex justify-between text-xs">
                        <span>Kembalian</span>
                        <span>Rp {{ number_format(max(0, (float) $order->paid_amount - (float) $order->total_price)) }}</span>
                    </div>
                @endif
            </div>

            <hr class="my-3">

            <div class="text-center text-xs">
                <p>Terima kasih</p>
                <p>BookStore</p>
            </div>
        </div>
    </div>
</div>
@endsection
