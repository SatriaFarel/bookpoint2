@extends("layouts.app1")

@section("content")
<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">

        <h2 class="text-2xl font-bold text-center mb-6">
            Buat Akun Baru
        </h2>

        {{-- ROLE SELECT --}}
        <div class="flex gap-2 mb-6">
            <button type="button" onclick="setRole('customer')" id="btnCustomer"
                class="flex-1 py-2 rounded bg-blue-600 text-white">
                Customer
            </button>

            <button type="button" onclick="setRole('seller')" id="btnSeller"
                class="flex-1 py-2 rounded bg-slate-200">
                Seller
            </button>
        </div>

        {{-- ERROR --}}
        @if(session('error'))
            <p class="text-red-600 mb-4">{{ session('error') }}</p>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        <form method="POST" action="/auth/register" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <input type="hidden" name="role" id="roleInput" value="customer">

            {{-- FOTO PROFIL --}}
            <div>
                <label class="block text-sm text-slate-600 mb-1">
                    Foto Profil
                </label>
                <input type="file" name="foto" accept="image/*" class="w-full text-sm" required>
            </div>

            <input name="nik"
                placeholder="NIK"
                class="w-full border px-4 py-2 rounded">

            <input name="name"
                placeholder="Nama Lengkap"
                class="w-full border px-4 py-2 rounded">

            <input name="email"
                type="email"
                placeholder="Email"
                class="w-full border px-4 py-2 rounded">

            {{-- <input name="alamat"
                type="text"
                placeholder="Alamat"
                class="w-full border px-4 py-2 rounded"> --}}

            <input name="password"
                type="password"
                placeholder="Password"
                class="w-full border px-4 py-2 rounded">

            <input name="password_confirmation"
                type="password"
                placeholder="Konfirmasi Password"
                class="w-full border px-4 py-2 rounded">

            {{-- SELLER ONLY --}}
            <div id="sellerFields" class="hidden space-y-4">

                <input name="no_rekening"
                    placeholder="Nomor Rekening"
                    class="w-full border px-4 py-2 rounded">

                <div>
                    <label class="block text-sm text-slate-600 mb-1">
                        QRIS (Opsional)
                    </label>
                    <input type="file" name="qris" accept="image/*" class="w-full text-sm">
                </div>

            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Daftar
            </button>

        </form>

        <div class="mt-6 text-center text-sm">
            Sudah punya akun?
            <a href="/login" class="text-blue-600 hover:underline">
                Login
            </a>
        </div>

    </div>
</div>

<script>
function setRole(role) {

    document.getElementById('roleInput').value = role;

    const sellerFields = document.getElementById('sellerFields');

    const btnCustomer = document.getElementById('btnCustomer');
    const btnSeller = document.getElementById('btnSeller');

    if(role === 'seller'){
        sellerFields.classList.remove('hidden');

        btnSeller.classList.remove('bg-slate-200');
        btnSeller.classList.add('bg-blue-600','text-white');

        btnCustomer.classList.remove('bg-blue-600','text-white');
        btnCustomer.classList.add('bg-slate-200');

    } else {

        sellerFields.classList.add('hidden');

        btnCustomer.classList.remove('bg-slate-200');
        btnCustomer.classList.add('bg-blue-600','text-white');

        btnSeller.classList.remove('bg-blue-600','text-white');
        btnSeller.classList.add('bg-slate-200');
    }
}
</script>
@endsection