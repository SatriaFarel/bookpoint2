@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/40 to-emerald-50/40">

        {{-- NAV --}}
        <nav class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-20 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex justify-between h-16 items-center">

                    <div class="flex items-center gap-8">

                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight hover:text-blue-600 transition">
                            BookPoint
                        </h1>

                        <div class="hidden md:flex gap-6 text-sm font-medium">

                            <a href="/customer/dashboard" class="text-blue-600 border-b-2 border-blue-600 pb-1">
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

                        <form method="GET" action="/customer/dashboard" class="relative">

                            <input name="search" placeholder="Cari buku favoritmu..."
                                class="w-full pl-10 pr-4 py-2 rounded-full border border-slate-200 focus:ring-2 focus:ring-blue-400 outline-none transition"
                                value="{{ request('search') }}">

                            <span class="absolute left-3 top-2.5 text-slate-400">🔍</span>

                        </form>

                    </div>


                    <div class="flex items-center gap-3">

                        {{-- CART --}}
                        <a href="/customer/cart" class="relative p-2 rounded-full hover:bg-white transition">

                            <span class="text-2xl">🛒</span>

                            @if($cartCount > 0)

                                <span
                                    class="absolute -top-1 -right-1 bg-blue-600 text-white
                                                                        text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold animate-pulse">

                                    {{ $cartCount }}

                                </span>

                            @endif

                        </a>

                        <a href="{{ route('customer.profile.edit') }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 1115 0" />
                            </svg>
                            <span class="hidden sm:inline text-sm font-medium">Profil</span>
                        </a>

                        <form method="POST" action="/auth/logout">
                            @csrf

                            <button class="text-sm text-slate-500 hover:text-red-500 transition px-2 py-1">
                                Logout
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </nav>


        {{-- HERO --}}
        <header class="mb-12">
            <div class="max-w-7xl mx-auto px-4">

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

                    <a href=""
                        class="px-7 py-3 bg-blue-500 hover:bg-blue-600 transition rounded-xl font-semibold shadow-lg hover:shadow-xl">

                        Lihat Promo

                    </a>

                </div>

                <div class="hidden md:block text-[12rem] opacity-10 select-none animate-pulse">
                    📚
                </div>

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

            <section class="mb-8 space-y-4">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Filter kategori</p>
                        <p class="text-xs text-slate-500">Pilih kategori untuk menampilkan produk yang sesuai.</p>
                    </div>

                    @if(request('search') || $selectedCategory)
                        <a href="/customer/dashboard"
                           class="inline-flex items-center px-4 py-2 rounded-full border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:text-blue-600 hover:border-blue-200 transition">
                            Reset Filter
                        </a>
                    @endif
                </div>

                <div class="flex gap-3 overflow-x-auto pb-2">
                    <a href="{{ route('dashboard', array_filter(['search' => request('search')])) }}"
                       class="whitespace-nowrap px-4 py-2 rounded-full border text-sm font-medium transition {{ empty($selectedCategory) ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-200 hover:text-blue-600' }}">
                        Semua
                    </a>

                    @foreach($categories as $category)
                        <a href="{{ route('dashboard', array_filter(['search' => request('search'), 'category' => $category->id])) }}"
                           class="whitespace-nowrap px-4 py-2 rounded-full border text-sm font-medium transition {{ (string) $selectedCategory === (string) $category->id ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-200 hover:text-blue-600' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </section>

            @if($books->isEmpty())

                <div class="flex flex-col items-center justify-center text-center py-20">

                    <div class="text-6xl mb-4 opacity-70">📚</div>

                    <h2 class="text-xl font-bold text-slate-700 mb-2">
                        Buku tidak ditemukan
                    </h2>

                    <p class="text-slate-500 text-sm mb-6 max-w-md">
                        Coba cari dengan kata kunci lain atau cek kembali nanti.
                    </p>

                    <a href="/customer/dashboard"
                       class="px-5 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl text-sm shadow inline-block">
                        Reset Filter
                    </a>
                    
                </div>

            @else

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-7">

                @foreach($books as $book)

                    @php
                        $finalPrice = $book->discount_percent
                            ? $book->price - ($book->price * $book->discount_percent / 100)
                            : $book->price;
                    @endphp


                    <div class="bg-white rounded-2xl border border-slate-200
                                                    overflow-hidden group hover:shadow-xl hover:-translate-y-1
                                                    transition duration-300 cursor-pointer"
                        onclick="openProduct({{ $book->id }})">

                        {{-- IMAGE --}}
                        <div class="relative aspect-[3/4] overflow-hidden">

                            <img src="{{ asset('storage/' . $book->image) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                            @if($book->discount_percent > 0)

                                <span
                                    class="absolute top-2 left-2 bg-red-500 text-white
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


                            <button type="button"
                                    onclick="openProduct({{ $book->id }}); event.stopPropagation();"
                                    class="mt-2 w-full text-xs py-2 rounded-lg
                                           bg-slate-900 hover:bg-blue-600
                                           text-white transition font-semibold">
                                Lihat Detail
                            </button>

                        </div>

                    </div>

                    {{-- MODAL DETAIL --}}
                    <div id="productModal{{ $book->id }}"
                        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">

                        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden">

                            {{-- HEADER --}}
                            <div class="flex justify-between items-center p-4 border-b">
                                <h2 class="font-bold text-lg text-slate-800">
                                    Detail Buku
                                </h2>
                                <button onclick="closeProduct({{ $book->id }})" class="text-slate-400 hover:text-black text-xl">
                                    ×
                                </button>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4 p-4">

                                {{-- IMAGE --}}
                                <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-64 object-cover rounded-lg">

                                {{-- INFO --}}
                                <div class="space-y-3">

                                    <p class="text-xs text-blue-600 font-semibold uppercase">
                                        {{ $book->category->name ?? '-' }}
                                    </p>

                                    <h3 class="text-lg font-bold text-slate-800">
                                        {{ $book->name }}
                                    </h3>

                                    {{-- PRICE --}}
                                    @if($book->discount_percent > 0)
                                        <p class="text-sm line-through text-slate-400">
                                            Rp {{ number_format($book->price) }}
                                        </p>
                                    @endif

                                    <p class="text-xl font-bold text-red-600">
                                        Rp {{ number_format($finalPrice) }}
                                    </p>

                                    {{-- DESKRIPSI --}}
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        {{ $book->description ?? 'Tidak ada deskripsi tersedia.' }}
                                    </p>

                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div class="bg-slate-50 rounded-lg p-2">
                                            <p class="text-slate-500">Stok</p>
                                            <p class="font-semibold text-slate-700">{{ $book->stock ?? 0 }}</p>
                                        </div>
                                        <div class="bg-slate-50 rounded-lg p-2">
                                            <p class="text-slate-500">ID Produk</p>
                                            <p class="font-semibold text-slate-700">#{{ $book->id }}</p>
                                        </div>
                                    </div>

                                    {{-- BUTTON --}}
                                    <form method="POST" action="/customer/cart/add" onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $book->id }}">

                                        <button class="w-full mt-3 py-2 rounded-lg
                                                bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                                            + Tambah ke Keranjang
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            @endif

        </main>

    </div>


    <script>

        const searchInput = document.querySelector('input[name="search"]');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {

                clearTimeout(window.searchTimer);

                window.searchTimer = setTimeout(() => {

                    const value = this.value;

                    const params = new URLSearchParams(window.location.search);

                    if (value) {
                        params.set('search', value);
                    } else {
                        params.delete('search');
                    }

                    window.location = "/customer/dashboard?" + params.toString();

                }, 500);

            });
        }

        function openProduct(id) {
            const modal = document.getElementById('productModal' + id)
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeProduct(id) {
            const modal = document.getElementById('productModal' + id)
            modal.classList.add('hidden')
            modal.classList.remove('flex')
        }

    </script>

@endsection
