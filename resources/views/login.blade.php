@extends('layouts.app1')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">

        {{-- HEADER --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-900 rounded-2xl mb-4 shadow-lg">
                <span class="text-white text-2xl">📚</span>
            </div>

            <h2 class="text-3xl font-bold text-slate-900">BookPoint</h2>
            <p class="text-slate-500 mt-2">Silakan login ke akun Anda</p>
        </div>

        {{-- ERROR --}}
        @if(session('error'))
        <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
            {{ session('error') }}
        </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="/auth/login" class="space-y-6">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Email"
                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600"
                required
            >

            <div class="text-right">
                <a href="/customer/forgot-password" class="text-sm text-blue-600 hover:underline">
                    Lupa password?
                </a>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition"
            >
                Login
            </button>

        </form>

        <div class="mt-8 text-center text-sm text-slate-600">
            Belum punya akun?
            <a href="/customer/register" class="text-blue-600 hover:underline font-medium">
                Daftar sekarang
            </a>
        </div>

    </div>

</div>

@endsection