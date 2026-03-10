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

                    <a href="/about" class="text-blue-600 border-b-2 border-blue-600 pb-1">
                        About Us
                    </a>

                </div>

            </div>

        </nav>


        {{-- CONTENT --}}
        <main class="max-w-4xl mx-auto py-12 px-6 space-y-10">

            <h1 class="text-3xl font-bold text-center text-slate-800">
                About Us
            </h1>


            <p class="text-slate-600 text-center max-w-2xl mx-auto text-lg">
                BookStore adalah platform toko buku online yang menyediakan berbagai
                buku berkualitas untuk membantu pengguna mendapatkan pengetahuan,
                referensi belajar, dan hiburan melalui membaca.
            </p>


            {{-- VISI --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition">

                <h2 class="text-xl font-semibold mb-2 text-slate-800">
                    Visi
                </h2>

                <p class="text-slate-600">
                    Menjadi platform toko buku digital yang memudahkan masyarakat
                    dalam mendapatkan buku berkualitas dengan cepat dan mudah.
                </p>

            </div>


            {{-- MISI --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition">

                <h2 class="text-xl font-semibold mb-3 text-slate-800">
                    Misi
                </h2>

                <ul class="list-disc pl-5 text-slate-600 space-y-2">

                    <li>Menyediakan berbagai koleksi buku berkualitas.</li>
                    <li>Memberikan pengalaman belanja yang mudah dan nyaman.</li>
                    <li>Mendukung budaya membaca di masyarakat.</li>

                </ul>

            </div>


            {{-- KONTAK --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition space-y-4">

                <h2 class="text-xl font-semibold text-slate-800">
                    Kontak
                </h2>

                <div class="text-slate-600 space-y-1">

                    <p>
                        <span class="font-medium">Email :</span>
                        satriafarel40@email.com
                    </p>

                    <p>
                        <span class="font-medium">WhatsApp :</span>
                        088299309375
                    </p>

                </div>


                <a href="https://wa.me/6288299309375?text=Halo%20Admin%20BookStore%2C%20saya%20ingin%20bertanya%20tentang%20toko."
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold shadow hover:shadow-lg transition">

                    {{-- icon WA --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">

                        <path
                            d="M12.04 2C6.58 2 2.14 6.42 2.14 11.88c0 1.92.5 3.7 1.48 5.28L2 22l4.98-1.56c1.5.82 3.2 1.26 5.06 1.26 5.46 0 9.9-4.42 9.9-9.88S17.5 2 12.04 2zm5.72 14.22c-.24.68-1.42 1.3-1.96 1.38-.5.08-1.14.12-1.84-.1-.42-.14-.96-.3-1.66-.6-2.92-1.26-4.82-4.2-4.96-4.4-.14-.2-1.18-1.56-1.18-2.98 0-1.42.74-2.12 1-2.4.26-.28.56-.34.74-.34.18 0 .36 0 .52.02.16.02.36-.06.56.42.24.6.82 2.08.9 2.24.08.16.12.34.02.54-.1.2-.14.34-.28.52-.14.18-.3.4-.42.54-.14.16-.28.32-.12.62.16.3.72 1.18 1.54 1.92 1.06.94 1.96 1.22 2.26 1.36.3.14.48.12.66-.08.18-.2.74-.86.94-1.16.2-.3.4-.24.68-.14.28.1 1.8.86 2.1 1.02.3.16.5.24.58.38.08.14.08.8-.16 1.48z" />

                    </svg>

                    Hubungi Admin via WhatsApp

                </a>

            </div>

        </main>

    </div>

@endsection