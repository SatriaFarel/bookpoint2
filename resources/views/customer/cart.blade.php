@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">

        {{-- NAV --}}
           <nav class="bg-white/70 backdrop-blur border-b border-indigo-100 sticky top-0 z-20 px-4 py-4 shadow-sm">
            <div class="max-w-5xl mx-auto flex items-center gap-4 p-4">

                <a href="/customer/dashboard" class="text-lg hover:text-blue-600 transition">←</a>

                <h1 class="text-xl font-bold text-slate-800">
                    Keranjang
                </h1>

            </div>
        </nav>


        <main class="max-w-5xl mx-auto p-4 grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- CART ITEMS --}}
            <div class="lg:col-span-2 space-y-5">

                @if ($errors->has('cart'))
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        {{ $errors->first('cart') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse($cartItems as $item)

                                <div class="bg-white p-4 rounded-2xl border border-slate-200
                    flex gap-4 items-center hover:shadow-lg transition group">

                                    <input type="checkbox" class="cart-check w-5 h-5 accent-blue-600" data-price="{{ $item['price'] }}"
                                        data-qty="{{ $item['qty'] }}" checked>


                                    <div class="overflow-hidden rounded-lg">

                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-20 h-28 object-cover rounded-lg
                    group-hover:scale-105 transition duration-300">

                                    </div>


                                    <div class="flex-1">

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $item['name'] }}
                                        </h3>

                                        <p class="text-sm text-slate-500">
                                            Qty: {{ $item['qty'] }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            Stok tersedia: {{ $item['stock'] ?? '-' }}
                                        </p>

                                        <p class="font-bold text-blue-600 mt-1">
                                            Rp {{ number_format($item['price'] * $item['qty']) }}
                                        </p>

                                        <div class="mt-3 flex items-center gap-2" onclick="event.stopPropagation()">
                                            <form method="POST" action="/customer/cart/update/{{ $item['id'] }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="qty" value="{{ max(1, $item['qty'] - 1) }}">
                                                <button class="w-8 h-8 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 transition"
                                                        {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                                                    -
                                                </button>
                                            </form>

                                            <span class="text-sm font-semibold w-8 text-center">{{ $item['qty'] }}</span>

                                            <form method="POST" action="/customer/cart/update/{{ $item['id'] }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                                <button class="w-8 h-8 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 transition"
                                                        {{ isset($item['stock']) && $item['qty'] >= $item['stock'] ? 'disabled' : '' }}>
                                                    +
                                                </button>
                                            </form>
                                        </div>

                                    </div>


                                    <form method="POST" action="/customer/cart/remove/{{ $item['id'] }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-500 hover:text-red-600 text-lg hover:scale-110 transition">

                                            🗑️

                                        </button>

                                    </form>

                                </div>

                @empty

                    <div class="text-center text-slate-500 py-20">

                        <p class="text-lg font-semibold mb-2">
                            Keranjang kosong
                        </p>

                        <p class="text-sm">
                            Tambahkan buku favoritmu dulu
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- SUMMARY --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-fit">

                <h2 class="font-bold text-slate-800 mb-4 text-lg">
                    Ringkasan Belanja
                </h2>


                <div class="space-y-3 text-sm">

                    <div class="flex justify-between text-slate-500">

                        <span>Total Produk</span>

                        <span>{{ count($cartItems) }}</span>

                    </div>


                    <div class="border-t pt-3 flex justify-between font-bold text-lg">

                        <span>Total</span>

                        <span id="cartTotal" class="text-blue-600">

                            Rp {{ number_format($total) }}

                        </span>

                    </div>

                </div>


                <button onclick="checkout()" class="w-full mt-6 bg-slate-900 hover:bg-blue-600
    text-white py-3 rounded-xl font-semibold
    transition shadow hover:shadow-lg">

                    Checkout

                </button>

            </div>

        </main>

    </div>


    <script>

        const checks = document.querySelectorAll('.cart-check');
        const totalEl = document.getElementById('cartTotal');

        function calculateTotal() {

            let total = 0;

            checks.forEach(c => {

                if (c.checked) {

                    const price = Number(c.dataset.price);
                    const qty = Number(c.dataset.qty);

                    total += price * qty;

                }

            });

            totalEl.innerText = "Rp " + total.toLocaleString();

        }

        checks.forEach(c => {
            c.addEventListener('change', calculateTotal);
        });

        function checkout() {

            const checked = [...checks].filter(c => c.checked);

            if (checked.length === 0) {
                alert('Pilih minimal 1 produk');
                return;
            }

            window.location.href = "/customer/checkout";

        }

    </script>

@endsection
