<x-filament-panels::page>
    @php
        $role = auth()->user()->role;
    @endphp

    <div class="max-w-4xl mx-auto space-y-8">

        {{-- ================= SELLER ================= --}}
        @if($role === 'seller')

            <div class="text-center">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    Bantuan & Panduan Seller
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">
                    Panduan penggunaan platform Lumina untuk penjual.
                </p>
            </div>

            @php
                $faqs = [
                    [
                        "q" => "Bagaimana cara upload produk?",
                        "a" => "Pergi ke menu Produk, klik tombol Tambah Produk lalu isi detail buku."
                    ],
                    [
                        "q" => "Kapan dana penjualan cair?",
                        "a" => "Dana masuk ke saldo maksimal 1x24 jam setelah pesanan dikonfirmasi."
                    ],
                    [
                        "q" => "Bagaimana cara input resi?",
                        "a" => "Masuk menu Pesanan lalu isi nomor resi pada pesanan yang disetujui."
                    ],
                    [
                        "q" => "Mengapa pesanan ditolak?",
                        "a" => "Biasanya karena stok habis atau pembayaran tidak valid."
                    ]
                ];
            @endphp

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm border border-slate-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                            <span class="text-blue-600 mr-2 text-xl font-black">Q:</span>
                            {{ $faq['q'] }}
                        </h3>
                        <p class="text-slate-600 dark:text-gray-300 ml-7 leading-relaxed">
                            {{ $faq['a'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="bg-blue-600 p-8 rounded-2xl text-white text-center">
                <h2 class="text-xl font-bold mb-2">Masih butuh bantuan?</h2>
                <p class="opacity-90 mb-6">Hubungi CS kami untuk bantuan seller.</p>
                <button class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold">
                    Chat Support
                </button>
            </div>

        {{-- ================= ADMIN ================= --}}
        @elseif($role === 'admin')

            <div class="text-center">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    Bantuan Super Admin
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">
                    Panduan mengelola sistem Lumina.
                </p>
            </div>

            @php
                $faqs = [
                    [
                        "q" => "Apa tugas Super Admin?",
                        "a" => "Mengelola seluruh sistem dan user."
                    ],
                    [
                        "q" => "Bagaimana mengelola seller?",
                        "a" => "Masuk menu Manajemen Seller."
                    ],
                    [
                        "q" => "Bagaimana memantau transaksi?",
                        "a" => "Gunakan menu Transaksi."
                    ],
                    [
                        "q" => "Jika ada sengketa?",
                        "a" => "Tinjau bukti pembayaran dan status pesanan."
                    ]
                ];
            @endphp

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm border border-slate-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 flex items-center">
                            <span class="text-purple-600 mr-2 text-xl font-black">Q:</span>
                            {{ $faq['q'] }}
                        </h3>
                        <p class="text-slate-600 dark:text-gray-300 ml-7 leading-relaxed">
                            {{ $faq['a'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="bg-purple-600 p-8 rounded-2xl text-white text-center">
                <h2 class="text-xl font-bold mb-2">
                    Bantuan Teknis
                </h2>
                <p class="opacity-90 mb-6">
                    Hubungi developer jika ada masalah sistem.
                </p>
                <button class="bg-white text-purple-600 px-8 py-3 rounded-full font-bold">
                    Hubungi Tim Teknis
                </button>
            </div>

        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</x-filament-panels::page>