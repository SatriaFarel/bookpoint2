@extends('layouts.app1')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/40 to-emerald-50/40 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Pesanan Berhasil Dibuat</h1>
        </div>

        <p class="text-slate-600 mb-5">
            Simpan kode order berikut untuk konfirmasi pembayaran ke admin:
        </p>

        <div class="space-y-4 mb-6">
            @forelse($orderCodes as $code)
                @php
                    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($code);
                @endphp
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-slate-500">Kode Order</span>
                        <span class="font-bold text-blue-600 tracking-wide">{{ $code }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <img
                            src="{{ $qrUrl }}"
                            alt="QR {{ $code }}"
                            class="w-36 h-36 border border-slate-200 rounded-xl bg-white p-2"
                        >

                        <div class="text-xs text-slate-500 leading-relaxed">
                            Tunjukkan QR ini ke admin saat pembayaran.
                            <br>
                            Admin bisa scan QR untuk mengisi kode order otomatis.
                            <div class="mt-3 flex flex-wrap gap-2">
                                <a href="{{ $qrUrl }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 transition">
                                    Buka QR
                                </a>
                                <a href="{{ $qrUrl }}" download="qr-{{ $code }}.png"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                    Download QR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl px-4 py-3 text-sm">
                    Kode order tidak ditemukan. Silakan cek riwayat transaksi.
                </div>
            @endforelse
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/customer/transactions" class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                Lihat Riwayat Transaksi
            </a>
            <a href="/customer/dashboard" class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition border border-slate-200">
                Kembali ke Store
            </a>
        </div>
    </div>
</div>
@endsection
