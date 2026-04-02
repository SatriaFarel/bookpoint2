@extends('layouts.app1')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-emerald-50">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-indigo-100 sticky top-0 z-20 px-4 py-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex justify-between items-center">

            <a href="/customer/dashboard"
               class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">
                BookStore
            </a>

            <div class="hidden md:flex gap-6 text-sm font-medium">
                <a href="/customer/dashboard" class="text-slate-500 hover:text-indigo-600 transition">
                    Store
                </a>
                <a href="/customer/about" class="text-indigo-600 border-b-2 border-indigo-600 pb-1">
                    About Us
                </a>
            </div>

            @include('customer.partials.mobile-sidebar', ['active' => 'about'])

        </div>
    </nav>


    {{-- HERO --}}
    <section class="text-center py-14 px-6">

        <h1 class="text-4xl font-extrabold text-slate-800 mb-4">
            Tentang <span class="text-indigo-600">BookStore</span>
        </h1>

        <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Platform toko buku online yang menyediakan berbagai buku berkualitas
            untuk kebutuhan belajar, referensi, dan hiburan dalam satu tempat.
        </p>

    </section>


    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto px-6 pb-16 space-y-8">

        <div class="grid md:grid-cols-2 gap-6">

            {{-- VISI --}}
            <div class="bg-white/80 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition">

                <h2 class="text-xl font-semibold mb-3 text-indigo-600">
                    Visi
                </h2>

                <p class="text-slate-600 leading-relaxed">
                    Menjadi platform toko buku digital yang memudahkan masyarakat
                    dalam mendapatkan buku berkualitas dengan cepat, aman, dan nyaman.
                </p>

            </div>


            {{-- MISI --}}
            <div class="bg-white/80 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition">

                <h2 class="text-xl font-semibold mb-3 text-indigo-600">
                    Misi
                </h2>

                <ul class="text-slate-600 space-y-2 text-sm">

                    <li class="flex gap-2">
                        <span>✔</span> Menyediakan koleksi buku berkualitas
                    </li>

                    <li class="flex gap-2">
                        <span>✔</span> Memberikan pengalaman belanja yang mudah
                    </li>

                    <li class="flex gap-2">
                        <span>✔</span> Mendukung budaya membaca
                    </li>

                </ul>

            </div>

        </div>


        {{-- KONTAK --}}
        <div class="bg-white/90 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition space-y-5">

            <h2 class="text-xl font-semibold text-slate-800">
                Kontak Kami
            </h2>

            <div class="grid sm:grid-cols-2 gap-4 text-sm">

                <div class="bg-slate-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Email</p>
                    <p class="font-medium text-slate-800">
                        satriafarel40@email.com
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">WhatsApp</p>
                    <p class="font-medium text-slate-800">
                        088299309375
                    </p>
                </div>

            </div>


            {{-- BUTTON --}}
            <a href="https://wa.me/6288299309375?text=Halo%20Admin%20BookStore%2C%20saya%20ingin%20bertanya."
               target="_blank"
               class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 
                      bg-gradient-to-r from-green-500 to-emerald-500 
                      hover:opacity-90 text-white rounded-xl font-semibold shadow transition">

                {{-- icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.04 2C6.58 2 2.14 6.42 2.14 11.88c0 1.92.5 3.7 1.48 5.28L2 22l4.98-1.56c1.5.82 3.2 1.26 5.06 1.26 5.46 0 9.9-4.42 9.9-9.88S17.5 2 12.04 2z"/>
                </svg>

                Hubungi via WhatsApp

            </a>

        </div>

    </main>

</div>

@endsection
