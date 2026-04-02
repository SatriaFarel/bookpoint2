@extends('layouts.app1')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-emerald-50">

    {{-- NAVBAR --}}
    <nav class="bg-white/70 backdrop-blur border-b border-indigo-100 sticky top-0 z-20 px-4 py-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex justify-between items-center">

            <a href="/customer/dashboard"
               class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">
                BookStore
            </a>

            <div class="flex gap-6 text-sm font-medium">
                <a href="/customer/dashboard" class="text-slate-500 hover:text-indigo-600 transition">
                    Store
                </a>
                <a href="/customer/transactions" class="text-indigo-600 border-b-2 border-indigo-600 pb-1">
                    History
                </a>
            </div>

        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto p-4 py-8 space-y-6">

        <h1 class="text-2xl font-bold text-slate-800">
            Riwayat Transaksi
        </h1>

        @if($orders->isEmpty())
            <div class="bg-white p-10 rounded-2xl border text-slate-500 text-center shadow-sm">
                <p class="text-lg font-semibold mb-2">Belum ada transaksi</p>
                <p class="text-sm">Mulai belanja buku favoritmu sekarang</p>
            </div>
        @endif

        <div class="space-y-5">

            @foreach($orders as $order)
                @php
                    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($order->order_code);
                @endphp

                <div class="bg-white/80 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    {{-- HEADER --}}
                    <div class="flex justify-between items-start gap-4">

                        <div class="space-y-4 w-full">

                            {{-- SELLER --}}
                            <div class="flex items-center gap-3">

                                <div class="w-9 h-9 rounded-full bg-gradient-to-r from-indigo-500 to-blue-500 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr($order->seller->name ?? 'A', 0, 1)) }}
                                </div>

                                <div class="text-sm leading-tight">
                                    <p class="font-semibold text-slate-800">
                                        {{ $order->seller->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Penjual
                                    </p>
                                </div>

                            </div>

                            {{-- CODE + STATUS --}}
                            <div class="flex items-center gap-3 flex-wrap">

                                <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">
                                    {{ $order->order_code }}
                                </span>

                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                    @if($order->status == 'paid') bg-emerald-100 text-emerald-600
                                    @elseif($order->status == 'pending') bg-amber-100 text-amber-600
                                    @elseif($order->status == 'done') bg-indigo-100 text-indigo-600
                                    @else bg-slate-200 text-slate-600
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>

                                @if($order->status == 'pending')
                                    <span class="text-xs text-red-500 font-medium">
                                        Menunggu pembayaran
                                    </span>
                                @endif

                            </div>

                            {{-- ITEMS --}}
                            <h3 class="font-semibold text-slate-800 line-clamp-2">
                                @foreach($order->items as $item)
                                    {{ $item->name }}
                                    @if(!$loop->last) @endif
                                @endforeach
                            </h3>

                            {{-- DETAIL --}}
                            <div class="text-xs text-slate-500 space-y-1">

                                <p>{{ $order->created_at->format('d M Y H:i') }}</p>

                                <p>
                                    Metode:
                                    <span class="font-medium">
                                        {{ $order->payment_method ?? '-' }}
                                    </span>
                                </p>

                                <p>
                                    Dibayar:
                                    <span class="font-medium">
                                        Rp {{ number_format($order->paid_amount ?? 0) }}
                                    </span>
                                </p>

                                @if($order->expedition)
                                    <p>Ekspedisi: {{ $order->expedition }}</p>
                                @endif

                                @if($order->resi)
                                    <p class="text-indigo-600 font-medium">
                                        Resi: {{ $order->resi }}
                                    </p>
                                @endif

                            </div>

                            @if($order->status == 'pending')
                                <div class="mt-4 p-3 rounded-xl border border-blue-100 bg-blue-50">
                                    <p class="text-xs font-semibold text-blue-700 mb-2">
                                        QR Pembayaran
                                    </p>

                                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                        <img
                                            src="{{ $qrUrl }}"
                                            alt="QR {{ $order->order_code }}"
                                            class="w-28 h-28 border border-blue-200 rounded-lg bg-white p-1.5"
                                        >

                                        <div class="text-xs text-slate-600">
                                            Tunjukkan QR ini ke admin untuk pembayaran.
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                <a href="{{ $qrUrl }}" target="_blank"
                                                   class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 transition">
                                                    Buka QR
                                                </a>
                                                <a href="{{ $qrUrl }}" download="qr-{{ $order->order_code }}.png"
                                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                                    Download QR
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        {{-- ACTION --}}
                        <a href="/customer/chat/{{ $order->seller_id }}"
                           class="px-4 py-2 text-sm rounded-lg bg-gradient-to-r from-indigo-500 to-blue-500 text-white shadow hover:opacity-90 transition whitespace-nowrap">
                            Chat Penjual
                        </a>

                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-end gap-2 mt-4">
                        @if ($order->status == 'paid' || $order->status == 'done')
                        <a href="{{ route('customer.invoice', $order->id) }}"
                                class="px-4 py-2 text-sm rounded-lg bg-slate-100 hover:bg-indigo-600 hover:text-white transition">
                            Lihat Invoice
                        </a>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>

    </main>

</div>
@endsection
