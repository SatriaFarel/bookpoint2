@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">

        {{-- NAV --}}
        <nav class="bg-white/80 backdrop-blur border-b sticky top-0 z-20 shadow-sm">
            <div class="max-w-5xl mx-auto flex items-center gap-4 p-4">

                <a href="/dashboard" class="text-lg hover:text-blue-600 transition">←</a>

                <h1 class="text-xl font-bold text-slate-800">
                    Keranjang
                </h1>

            </div>
        </nav>


        <main class="max-w-5xl mx-auto p-4 grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- CART ITEMS --}}
            <div class="lg:col-span-2 space-y-5">

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

                                        <p class="font-bold text-blue-600 mt-1">
                                            Rp {{ number_format($item['price'] * $item['qty']) }}
                                        </p>

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