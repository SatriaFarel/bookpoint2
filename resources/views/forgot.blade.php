<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-100 p-4">

<div class="bg-white w-full max-w-md p-8 rounded-xl shadow space-y-6">

    <h2 class="text-xl font-bold text-center">
        {{ session('step') == 2 ? 'Reset Password' : 'Forgot Password' }}
    </h2>

    @if(session('error'))
        <p class="text-red-500 text-center">{{ session('error') }}</p>
    @endif

    @if(session('success'))
        <p class="text-green-600 text-center">{{ session('success') }}</p>
    @endif


    {{-- STEP 1 --}}
    @if(session('step') != 2)

    <form method="POST" action="/customer/forgot-password">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Masukkan email"
            class="w-full border p-3 rounded"
            required
        >

        <button class="w-full bg-blue-600 text-white p-3 rounded mt-3">
            Kirim OTP
        </button>

    </form>

    @endif


    {{-- STEP 2 --}}
    @if(session('step') == 2)

    <form method="POST" action="/customer/reset-password">
        @csrf

        <input
            type="email"
            name="email"
            value="{{ session('email') }}"
            readonly
            class="w-full border p-3 rounded bg-slate-100"
        >

        <input
            type="text"
            name="otp"
            placeholder="OTP"
            class="w-full border p-3 rounded mt-3"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password baru"
            class="w-full border p-3 rounded mt-3"
            required
        >

        <input
            type="password"
            name="password_confirmation"
            placeholder="Konfirmasi password"
            class="w-full border p-3 rounded mt-3"
            required
        >

        <button class="w-full bg-green-600 text-white p-3 rounded mt-3">
            Reset Password
        </button>

    </form>

    @endif

</div>

</body>
</html>