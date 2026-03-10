@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">

        {{-- NAV --}}
        <nav class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-20 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-between h-16 items-center">

                    <div class="flex items-center gap-8">

                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight hover:text-blue-600 transition">
                            BookPoint
                        </h1>

                        <div class="hidden md:flex gap-6 text-sm font-medium">

                            <a href="/dashboard" class="text-blue-600 border-b-2 border-blue-600 pb-1">
                                Store
                            </a>

                            <a href="/customer/transactions" class="text-slate-500 hover:text-blue-600 transition">
                                History
                            </a>

                            <a href="/customer/about" class="text-slate-500 hover:text-blue-600 transition">
                                About Us
                            </a>

                        </div>

                    </div>

                    {{-- SEARCH --}}
                    <div class="flex-1 max-w-md mx-8 hidden sm:block">

                        <form method="GET" action="/customer" class="relative">

                            <input name="search" placeholder="Cari buku favoritmu..."
                                class="w-full pl-10 pr-4 py-2 rounded-full border border-slate-200 focus:ring-2 focus:ring-blue-400 outline-none transition"
                                value="{{ request('search') }}">

                            <span class="absolute left-3 top-2.5 text-slate-400">🔍</span>

                        </form>

                    </div>


                    <div class="flex items-center gap-4">

                        {{-- CART --}}
                        <a href="/customer/cart" class="relative p-2 hover:scale-110 transition">

                            <span class="text-2xl">🛒</span>

                            @if($cartCount > 0)

                                                        <span class="absolute -top-1 -right-1 bg-blue-600 text-white
                                text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold animate-pulse">

                                                            {{ $cartCount }}

                                                        </span>

                            @endif

                        </a>

                        <form method="POST" action="/auth/logout">
                            @csrf

                            <button class="text-sm text-slate-500 hover:text-red-500 transition">
                                Logout
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </nav>


        {{-- HERO --}}
        <header class="mb-12">

            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900
    rounded-3xl p-12 flex flex-col md:flex-row items-center justify-between
    text-white relative overflow-hidden shadow-xl">

                <div class="z-10">

                    <h2 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">

                        Temukan Dunia
                        <span class="text-blue-400">di Balik Kata.</span>

                    </h2>

                    <p class="text-slate-400 text-lg mb-8 max-w-lg">
                        Jelajahi ribuan koleksi buku pilihan terbaik hanya untukmu
                        dengan promo spesial hingga 50%.
                    </p>

                    <a href="/promo"
                        class="px-7 py-3 bg-blue-500 hover:bg-blue-600 transition rounded-xl font-semibold shadow-lg hover:shadow-xl">

                        Lihat Promo

                    </a>

                </div>

                <div class="hidden md:block text-[12rem] opacity-10 select-none animate-pulse">
                    📚
                </div>

            </div>

        </header>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="max-w-7xl mx-auto px-4 mb-6">

                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg shadow">

                    {{ session('success') }}

                </div>

            </div>

        @endif


        {{-- CONTENT --}}
        <main class="max-w-7xl mx-auto px-4 py-8">

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-7">

                @foreach($books as $book)

                                @php
                                    $finalPrice = $book->discount_percent
                                        ? $book->price - ($book->price * $book->discount_percent / 100)
                                        : $book->price;
                                @endphp


                                <div class="bg-white rounded-2xl border border-slate-200
                    overflow-hidden group hover:shadow-xl hover:-translate-y-1
                    transition duration-300">

                                    {{-- IMAGE --}}
                                    <div class="relative aspect-[3/4] overflow-hidden">

                                        <img src="{{ asset('storage/' . $book->image) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                                        @if($book->discount_percent > 0)

                                                                <span class="absolute top-2 left-2 bg-red-500 text-white
                                            text-xs font-bold px-2 py-1 rounded shadow">

                                                                    -{{ $book->discount_percent }}%

                                                                </span>

                                        @endif

                                    </div>


                                    <div class="p-4 space-y-2">

                                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">

                                            {{ $book->category->name ?? '-' }}

                                        </p>


                                        <h3 class="font-semibold text-sm line-clamp-2 text-slate-800">

                                            {{ $book->name }}

                                        </h3>


                                        @if($book->discount_percent > 0)

                                            <p class="text-xs line-through text-slate-400">

                                                Rp {{ number_format($book->price) }}

                                            </p>

                                        @endif


                                        <p class="font-bold text-red-600">

                                            Rp {{ number_format($finalPrice) }}

                                        </p>


                                        <form method="POST" action="/customer/cart/add">
                                            @csrf

                                            <input type="hidden" name="product_id" value="{{ $book->id }}">

                                            <button class="mt-2 w-full text-xs py-2 rounded-lg
                    bg-slate-900 hover:bg-blue-600
                    text-white transition font-semibold">

                                                + Keranjang

                                            </button>

                                        </form>

                                    </div>

                                </div>

                @endforeach

            </div>

        </main>

    </div>


    <script>

        const searchInput = document.querySelector('input[name="search"]');

        searchInput.addEventListener('keyup', function () {

            clearTimeout(window.searchTimer);

            window.searchTimer = setTimeout(() => {

                const value = this.value;

                window.location = "/dashboard?search=" + value;

            }, 500);

        });

    </script>

@endsection