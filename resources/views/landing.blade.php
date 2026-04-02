@extends('layouts.app1')

@section('content')

    <div class="min-h-screen bg-[radial-gradient(circle_at_top_right,_#dbeafe_0,_#f8fafc_45%,_#ecfeff_100%)]">

        <nav class="sticky top-0 z-30 backdrop-blur bg-white/80 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="text-2xl font-black tracking-tight text-slate-900">BookPoint</a>

                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition shadow">
                        Register
                    </a>
                </div>
            </div>
        </nav>

        <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                <div>
                    <p class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold mb-5">
                        Toko Buku Online
                    </p>

                    <h1 class="text-4xl sm:text-5xl font-black leading-tight text-slate-900">
                        Temukan Buku Favoritmu
                        <span class="text-blue-600">Dalam Satu Tempat</span>
                    </h1>

                    <p class="mt-5 text-slate-600 text-lg max-w-xl leading-relaxed">
                        Jelajahi koleksi buku terbaru dari berbagai kategori. Pilih buku, cek detail,
                        lalu lanjut belanja dengan pengalaman yang cepat dan nyaman.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow">
                            Mulai Belanja
                        </a>
                        <a href="#produk" class="px-6 py-3 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold hover:bg-slate-100 transition">
                            Lihat Produk
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-xl border border-blue-100">
                    <p class="text-sm text-blue-700 font-semibold">Kenapa BookPoint?</p>
                    <div class="mt-5 space-y-4">
                        <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                            <p class="font-semibold text-slate-800">Koleksi Terupdate</p>
                            <p class="text-sm text-slate-600 mt-1">Buku terbaru siap kamu baca kapan saja.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                            <p class="font-semibold text-slate-800">Harga Transparan</p>
                            <p class="text-sm text-slate-600 mt-1">Harga jelas, tanpa biaya tersembunyi.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-cyan-50 border border-cyan-100">
                            <p class="font-semibold text-slate-800">Belanja Cepat</p>
                            <p class="text-sm text-slate-600 mt-1">Checkout mudah dan proses pesanan lebih praktis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Produk Pilihan</h2>
                    <p class="text-slate-500 text-sm mt-1">Preview produk yang tersedia saat ini.</p>
                </div>
            </div>

            @if ($products->isEmpty())
                <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center text-slate-500">
                    Belum ada produk tersedia.
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach ($products as $product)
                        <article class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-[3/4] bg-slate-100 overflow-hidden">
                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover hover:scale-105 transition duration-300"
                                >
                            </div>

                            <div class="p-4">
                                <p class="text-[11px] uppercase tracking-wide font-bold text-blue-600">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </p>
                                <h3 class="mt-1 text-sm font-semibold line-clamp-2 min-h-[2.6rem]">
                                    {{ $product->name }}
                                </h3>
                                {{-- description --}}
                                <p class="mt-2 text-sm text-slate-500 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                <p class="mt-2 text-xs text-slate-500">Stok: {{ $product->stock }}</p>
                                <p class="mt-2 text-base font-black text-slate-900">Rp {{ number_format($product->price) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="mt-10 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow">
                    Login untuk Checkout
                </a>
            </div>
        </section>

    </div>
    
@endsection
