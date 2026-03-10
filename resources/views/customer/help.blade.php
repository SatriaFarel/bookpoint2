@extends("layouts.app1")

@section("content")

@php
    $role = auth()->user()->role;
@endphp

@if($role === 'customer')

<div class="max-w-4xl mx-auto space-y-8">

    <div class="text-center">
        <h1 class="text-3xl font-bold text-slate-900">
            Bantuan & Panduan Pembeli
        </h1>
        <p class="text-slate-500 mt-2">
            Panduan pembelian di Lumina.
        </p>
    </div>

    @php
        $faqs = [
            [
                "q" => "Bagaimana cara membeli produk?",
                "a" => "Klik beli sekarang lalu lanjut ke checkout."
            ],
            [
                "q" => "Bagaimana cara melakukan pembayaran?",
                "a" => "Pilih metode pembayaran saat checkout."
            ],
            [
                "q" => "Bagaimana melacak pesanan?",
                "a" => "Masuk ke menu Pesanan Saya lalu lihat statusnya."
            ],
            [
                "q" => "Barang tidak sesuai?",
                "a" => "Ajukan komplain maksimal 1x24 jam setelah barang diterima."
            ]
        ];
    @endphp

    <div class="space-y-4">
        @foreach($faqs as $faq)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                    <span class="text-blue-600 mr-2 text-xl font-black">Q:</span>
                    {{ $faq['q'] }}
                </h3>
                <p class="text-slate-600 ml-7 leading-relaxed">
                    {{ $faq['a'] }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="bg-blue-600 p-8 rounded-2xl text-white text-center">
        <h2 class="text-xl font-bold mb-2">Butuh bantuan?</h2>
        <p class="opacity-90 mb-6">CS siap membantu terkait pesanan.</p>
        <button class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold">
            Chat Support
        </button>
    </div>

</div>

@endif

@endsection