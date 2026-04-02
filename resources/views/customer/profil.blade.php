@extends('layouts.app1')

@section('content')
@php
    $userName = old('name', $user->name ?? 'Customer BookStore');
    $userEmail = old('email', $user->email ?? 'customer@bookstore.com');
    $userNik = old('nik', $user->nik ?? '');
    $userNoRekening = old('no_rekening', $user->no_rekening ?? '');
    $initial = strtoupper(substr($userName, 0, 1));
    $profileImage = $user?->image ? asset('storage/' . $user->image) : null;
@endphp

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-emerald-50">

    {{-- NAVBAR --}}
    <nav class="bg-white/70 backdrop-blur border-b border-indigo-100 sticky top-0 z-20 px-4 py-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex justify-between items-center">

            <a href="/customer/dashboard"
               class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">
                BookStore
            </a>

            <div class="flex gap-6 text-sm font-medium">
                <a href="/customer/dashboard" class="text-slate-500 hover:text-indigo-600 transition">
                    Store
                </a>
                <a href="/customer/about" class="text-slate-500 hover:text-indigo-600 transition">
                    About Us
                </a>
                <a href="{{ route('customer.profile.edit') }}" class="text-indigo-600 border-b-2 border-indigo-600 pb-1">
                    Profil
                </a>
            </div>

        </div>
    </nav>


    {{-- HERO --}}
    <section class="text-center py-14 px-6">

        <h1 class="text-4xl font-extrabold text-slate-800 mb-4">
            Profil <span class="text-indigo-600">Akun</span>
        </h1>

        <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Data profil diambil langsung dari database akunmu, dan bisa kamu edit
            untuk field yang aman seperti nama, email, NIK, dan no rekening.
        </p>

    </section>


    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto px-6 pb-16 space-y-8">

        @if (session('status') === 'profile-updated')
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm">
                Profil berhasil diperbarui.
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                Ada data yang belum valid. Cek kembali form profil.
            </div>
        @endif

        <div class="bg-white/90 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition">
            <div class="flex flex-col sm:flex-row items-center gap-5">

                @if($profileImage)
                    <img id="profilePreview"
                         src="{{ $profileImage }}"
                         alt="{{ $userName }}"
                         class="w-20 h-20 rounded-full object-cover shadow">
                @else
                    <div id="profileInitial"
                         class="w-20 h-20 rounded-full bg-gradient-to-r from-indigo-500 to-blue-500 text-white flex items-center justify-center text-3xl font-bold shadow">
                        {{ $initial }}
                    </div>
                    <img id="profilePreview"
                         src=""
                         alt="{{ $userName }}"
                         class="w-20 h-20 rounded-full object-cover shadow hidden">
                @endif

                <div class="text-center sm:text-left">
                    <h2 class="text-2xl font-bold text-slate-800">{{ $userName }}</h2>
                    <p class="text-slate-500">Member BookStore</p>
                </div>

            </div>
        </div>


        <div class="grid md:grid-cols-2 gap-6">

            <form method="POST"
                  action="{{ route('customer.profile.update') }}"
                  enctype="multipart/form-data"
                  class="bg-white/80 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition space-y-4">
                @csrf
                @method('PATCH')

                <h2 class="text-xl font-semibold text-indigo-600">
                    Edit Profil
                </h2>

                <div class="space-y-3 text-sm">
                    <div>
                        <label for="foto" class="block text-slate-600 mb-1">Foto Profil</label>
                        <input id="foto" name="foto" type="file" accept="image/*"
                               onchange="previewProfilePhoto(event)"
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
                        <p class="text-xs text-slate-400 mt-1">Format: jpg, jpeg, png, webp. Maksimal 2MB.</p>
                        @error('foto')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-slate-600 mb-1">Nama</label>
                        <input id="name" name="name" type="text" value="{{ $userName }}"
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-slate-600 mb-1">Email</label>
                        <input id="email" name="email" type="email" value="{{ $userEmail }}"
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div>
                        <label for="nik" class="block text-slate-600 mb-1">NIK</label>
                        <input id="nik" name="nik" type="text" value="{{ $userNik }}"
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
                        @error('nik')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div>
                        <label for="no_rekening" class="block text-slate-600 mb-1">No Rekening</label>
                        <input id="no_rekening" name="no_rekening" type="text" value="{{ $userNoRekening }}"
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300">
                        @error('no_rekening')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 hover:opacity-90 text-white rounded-xl font-semibold shadow transition">
                    Simpan Perubahan
                </button>
            </form>

{{-- 
            <div class="bg-white/80 backdrop-blur p-6 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-xl transition space-y-4">

                <h2 class="text-xl font-semibold text-indigo-600">
                    Info Aman
                </h2>

                <ul class="text-slate-600 space-y-3 text-sm">
                    <li class="flex gap-2">
                        <span>✔</span> Field sensitif seperti role, status, password, OTP tidak bisa diubah dari sini
                    </li>
                    <li class="flex gap-2">
                        <span>✔</span> Email harus unik antar akun user
                    </li>
                    <li class="flex gap-2">
                        <span>✔</span> Data yang disimpan hanya field yang sudah divalidasi
                    </li>
                </ul>

                <a href="/customer/dashboard"
                   class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-700 to-slate-600 hover:opacity-90 text-white rounded-xl font-semibold shadow transition">
                    Kembali ke Store
                </a>

            </div> --}}

        </div>

    </main>

</div>

<script>
    function previewProfilePhoto(event) {
        const file = event.target.files?.[0];
        const preview = document.getElementById('profilePreview');
        const initial = document.getElementById('profileInitial');

        if (!file || !preview) {
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');

        if (initial) {
            initial.classList.add('hidden');
        }
    }
</script>

@endsection
