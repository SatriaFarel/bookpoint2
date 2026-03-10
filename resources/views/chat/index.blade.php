@extends('layouts.app1')

@section('content')

    <div class="h-[80vh] bg-white rounded-2xl border shadow-xl flex overflow-hidden">

        {{-- ================= SIDEBAR ================= --}}
        <div class="w-80 border-r bg-gray-50 flex flex-col">

            {{-- HEADER --}}
            <div class="p-4 border-b flex items-center justify-between">

                <div class="flex items-center gap-2 font-bold text-gray-700 text-lg">
                    💬 Chat
                </div>

            </div>

            {{-- SEARCH --}}
            <div class="p-3 border-b">

                <input type="text" placeholder="Cari chat..."
                    class="w-full px-3 py-2 text-sm border rounded-lg focus:ring focus:ring-blue-200" />

            </div>

            {{-- LIST CHAT --}}
            <div class="overflow-y-auto flex-1">

                @foreach($chats as $c)

                    <a href="{{ route('chat.show', $c->id) }}"
                        class="flex items-center gap-3 px-4 py-3 hover:bg-white transition border-b">

                        {{-- AVATAR --}}
                        @if($c->foto)

                            <img src="{{ asset('storage/' . $c->foto) }}" class="w-11 h-11 rounded-full object-cover shadow" />

                        @else

                            <div
                                class="w-11 h-11 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold shadow">
                                {{ strtoupper(substr($c->name, 0, 1)) }}
                            </div>

                        @endif

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-gray-800">
                                {{ $c->name }}
                            </p>

                            <p class="text-xs text-gray-400">
                                Klik untuk chat
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>


        {{-- ================= CHAT ROOM ================= --}}
        <div class="flex-1 flex flex-col bg-gray-100">

            @if($partner)

                {{-- HEADER --}}
                <div class="p-4 border-b bg-white flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        {{-- BACK BUTTON --}}
                        <a href="javascript:history.go(-1)" class="px-3 py-1 text-sm border rounded-lg hover:bg-gray-100">
                            ← Back
                        </a>

                        {{-- AVATAR --}}
                        @if($partner->foto)

                            <img src="{{ asset('storage/' . $partner->foto) }}"
                                class="w-11 h-11 rounded-full object-cover shadow" />

                        @else

                            <div
                                class="w-11 h-11 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold shadow">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                            </div>

                        @endif

                        <div>

                            <p class="font-semibold text-gray-800">
                                {{ $partner->name }}
                            </p>

                            <p class="text-xs text-green-500">
                                Online
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================= MESSAGES ================= --}}
                <div id="messages" class="flex-1 p-6 overflow-y-auto space-y-3">

                    @foreach($messages as $m)

                        <div class="flex {{ $m->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                            <div class="
                                    px-4 py-2
                                    rounded-2xl
                                    text-sm
                                    max-w-sm
                                    shadow
                                    {{ $m->sender_id == auth()->id()
                        ? 'bg-blue-600 text-white rounded-br-none'
                        : 'bg-white border text-gray-700 rounded-bl-none'
                                    }}
                                    ">

                                {{ $m->message }}

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- ================= INPUT ================= --}}
                <form action="{{ route('messages.send') }}" method="POST" class="p-3 border-t bg-white flex gap-2">

                    @csrf

                    <input type="hidden" name="receiver_id" value="{{ $partner->id }}">

                    <input name="message" required
                        class="flex-1 border rounded-full px-4 py-2 text-sm focus:ring focus:ring-blue-200 outline-none"
                        placeholder="Ketik pesan...">

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full text-sm font-semibold shadow">

                        Kirim

                    </button>

                </form>

            @else

                {{-- EMPTY CHAT --}}
                <div class="flex-1 flex items-center justify-center text-gray-400">

                    <div class="text-center">

                        <p class="text-xl font-semibold">
                            Belum ada chat
                        </p>

                        <p class="text-sm">
                            Pilih user di sidebar untuk mulai percakapan
                        </p>

                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- AUTO SCROLL --}}
    <script>

        const box = document.getElementById('messages');

        if (box) {
            box.scrollTop = box.scrollHeight;
        }

    </script>

@endsection