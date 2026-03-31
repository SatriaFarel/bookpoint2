@extends("layouts.app1")

@section("content")

    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-blue-50 to-slate-100 p-4">

        <div class="max-w-md w-full bg-white/80 backdrop-blur rounded-2xl shadow-2xl p-8 space-y-6">

            <h2 class="text-2xl font-extrabold text-center text-slate-800">
                Buat Akun Baru
            </h2>

            {{-- ROLE SELECT --}}
            <div class="flex gap-2 bg-slate-100 p-1 rounded-xl">
                <button type="button" onclick="setRole('customer')" id="btnCustomer"
                    class="flex-1 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold transition">
                    Customer
                </button>
            </div>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUCCESS --}}
            @if(session('success'))
                <p class="text-green-500 text-sm">{{ session('success') }}</p>
            @endif

            <form method="POST" action="/auth/register" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="hidden" name="role" id="roleInput" value="customer">

                {{-- FOTO PROFIL --}}
                <div class="text-center">

                    <label class="block text-sm text-slate-600 mb-2">
                        Foto Profil
                    </label>

                    <div class="flex justify-center mb-3">

                        <img id="previewImage" src="https://ui-avatars.com/api/?name=User&background=6366f1&color=fff"
                            class="w-24 h-24 rounded-full object-cover shadow border">

                    </div>

                    <input type="file" name="foto" accept="image/*" onchange="previewFoto(event)"
                        class="w-full text-sm file:px-3 file:py-1 file:rounded file:border-0 file:bg-indigo-100 file:text-indigo-600 hover:file:bg-indigo-200"
                        required>

                </div>

                {{-- INPUT --}}
                <input name="nik" placeholder="NIK"
                    class="w-full border px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-400 outline-none">

                <input name="name" placeholder="Nama Lengkap"
                    class="w-full border px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-400 outline-none">

                <input name="email" type="email" placeholder="Email"
                    class="w-full border px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-400 outline-none">

                <input name="password" type="password" placeholder="Password"
                    class="w-full border px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-400 outline-none">

                <input name="password_confirmation" type="password" placeholder="Konfirmasi Password"
                    class="w-full border px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-400 outline-none">

                {{-- BUTTON --}}
                <button type="submit" class="w-full py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500
                               hover:opacity-90 text-white font-semibold shadow transition">

                    Daftar
                </button>

            </form>

            <div class="text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="/customer/login" class="text-indigo-600 font-medium hover:underline">
                    Login
                </a>
            </div>

        </div>

    </div>

    {{-- SCRIPT --}}
    <script>
        function setRole(role) {
            document.getElementById('roleInput').value = role;
        }

        // PREVIEW FOTO
        function previewFoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        }
    </script>

@endsection