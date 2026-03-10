@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">

        {{-- NAVBAR --}}
        <nav class="bg-white/80 backdrop-blur border-b sticky top-0 z-20 px-4 py-4 shadow-sm">
            <div class="max-w-5xl mx-auto flex justify-between items-center">

                <a href="/dashboard" class="text-xl font-extrabold text-slate-800 hover:text-blue-600 transition">
                    BookStore
                </a>

                <div class="flex gap-6 text-sm font-medium">

                    <a href="/dashboard" class="text-slate-500 hover:text-blue-600 transition">
                        Store
                    </a>

                    <a href="/customer/transactions" class="text-blue-600 border-b-2 border-blue-600 pb-1">
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

                    <p class="text-lg font-semibold mb-2">
                        Belum ada transaksi
                    </p>

                    <p class="text-sm">
                        Mulai belanja buku favoritmu sekarang
                    </p>

                </div>

            @endif


            <div class="space-y-5">

                @foreach($orders as $order)

                                <div
                                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition duration-300">

                                    {{-- HEADER --}}
                                    <div class="flex justify-between items-start">

                                        <div class="space-y-2">

                                            <div class="flex items-center gap-3">

                                                <span class="font-mono text-sm text-slate-400">
                                                    {{ $order->order_code }}
                                                </span>

                                                <span class="px-2 py-1 text-xs rounded-full font-semibold
                    @if($order->status == 'paid') bg-green-100 text-green-600
                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-600
                    @elseif($order->status == 'done') bg-purple-100 text-purple-600
                    @endif">

                                                    {{ strtoupper($order->status) }}

                                                </span>

                                            </div>


                                            <h3 class="font-semibold text-slate-800">

                                                @foreach($order->items as $item)

                                                    {{ $item->product->name }}

                                                    @if(!$loop->last)
                                                        ,
                                                    @endif

                                                @endforeach

                                            </h3>


                                            <p class="text-xs text-slate-400">

                                                {{ $order->created_at->format('d M Y H:i') }}

                                                •

                                                Rp {{ number_format($order->total_price) }}

                                            </p>

                                        </div>


                                        <a href="/customer/chat/{{ $order->seller_id }}"
                                            class="px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-blue-600 hover:text-white transition">

                                            Chat Penjual

                                        </a>

                                    </div>


                                    {{-- FOOTER --}}
                                    <div class="flex justify-end gap-2 mt-4">

                                        <button onclick="openInvoice({{ $order->id }})"
                                            class="px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-900 hover:text-white transition">

                                            Lihat Invoice

                                        </button>

                                    </div>

                                </div>



                                {{-- MODAL INVOICE --}}
                                <div id="invoiceModal{{ $order->id }}"
                                    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

                                    <div class="bg-white w-full max-w-md p-6 rounded-2xl space-y-4 shadow-xl animate-[fadeIn_.2s]">

                                        <div class="flex justify-between items-center">

                                            <h2 class="font-bold text-lg text-slate-800">
                                                Invoice
                                            </h2>

                                            <button onclick="closeInvoice({{ $order->id }})"
                                                class="text-slate-400 hover:text-black text-xl">

                                                ×

                                            </button>

                                        </div>


                                        <div class="text-sm space-y-1 text-slate-600">

                                            <p>
                                                <b>Order Code :</b>
                                                {{ $order->order_code }}
                                            </p>

                                            <p>
                                                <b>Tanggal :</b>
                                                {{ $order->created_at->format('d M Y H:i') }}
                                            </p>

                                            <p>
                                                <b>Status :</b>
                                                {{ $order->status }}
                                            </p>

                                        </div>


                                        <hr>


                                        <div class="space-y-2 text-sm">

                                            @foreach($order->items as $item)

                                                <div class="flex justify-between">

                                                    <span>
                                                        {{ $item->product->name }} x{{ $item->quantity }}
                                                    </span>

                                                    <span>
                                                        Rp {{ number_format($item->price * $item->quantity) }}
                                                    </span>

                                                </div>

                                            @endforeach

                                        </div>


                                        <hr>


                                        <div class="flex justify-between font-bold text-lg">

                                            <span>Total</span>

                                            <span class="text-blue-600">
                                                Rp {{ number_format($order->total_price) }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                @endforeach

            </div>

        </main>

    </div>


    <script>

        function openInvoice(id) {
            document.getElementById('invoiceModal' + id).classList.remove('hidden')
            document.getElementById('invoiceModal' + id).classList.add('flex')
        }

        function closeInvoice(id) {
            document.getElementById('invoiceModal' + id).classList.add('hidden')
            document.getElementById('invoiceModal' + id).classList.remove('flex')
        }

    </script>

@endsection