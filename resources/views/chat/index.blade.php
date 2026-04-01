@extends('layouts.app1')

@section('content')

<div class="h-[calc(100vh-64px)] flex overflow-hidden bg-gradient-to-br from-indigo-50 via-blue-50 to-slate-100">

    {{-- ================= SIDEBAR ================= --}}
    <div class="w-80 border-r bg-white/80 backdrop-blur flex flex-col">

        {{-- HEADER --}}
        <div class="p-4 border-b flex items-center justify-between">
            <div class="font-bold text-slate-800 text-lg flex items-center gap-2">
                💬 Chat
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="p-3 border-b">
            <input type="text" placeholder="Cari chat..."
                class="w-full px-3 py-2 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-400 outline-none" />
        </div>

        {{-- LIST CHAT --}}
        <div class="overflow-y-auto flex-1">

            @foreach($chats as $c)

                <a href="{{ route('chat.show', $c->id) }}"
                   class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-50 transition border-b">

                    {{-- AVATAR --}}
                    @if($c->image)
                        <img src="{{ asset('storage/' . $c->image) }}"
                             class="w-11 h-11 rounded-full object-cover shadow" />
                    @else
                        <div class="w-11 h-11 rounded-full bg-gradient-to-r from-indigo-500 to-blue-500
                                    text-white flex items-center justify-center font-semibold shadow">
                            {{ strtoupper(substr($c->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $c->name }}
                        </p>
                        <p class="text-xs text-slate-400">
                            Klik untuk chat
                        </p>
                    </div>

                </a>

            @endforeach

        </div>

    </div>


    {{-- ================= CHAT ROOM ================= --}}
    <div class="flex-1 flex flex-col">

        @if($partner)

            {{-- HEADER --}}
            <div class="p-4 border-b bg-white flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <a href="javascript:history.go(-1)"
                       class="px-3 py-1 text-sm border rounded-lg hover:bg-slate-100">
                        ←
                    </a>

                    @if($partner->image)
                        <img src="{{ asset('storage/' . $partner->image) }}"
                             class="w-11 h-11 rounded-full object-cover shadow" />
                    @else
                        <div class="w-11 h-11 rounded-full bg-gradient-to-r from-indigo-500 to-blue-500
                                    text-white flex items-center justify-center font-semibold shadow">
                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                        </div>
                    @endif

                    <div>
                        <p class="font-semibold text-slate-800">
                            {{ $partner->name }}
                        </p>
                        <p class="text-xs text-green-500">
                            Online
                        </p>
                    </div>

                </div>

            </div>


            {{-- ================= MESSAGES ================= --}}
            <div id="messages"
                 class="flex-1 p-6 overflow-y-auto space-y-3 bg-gradient-to-b from-slate-100 to-slate-200">

                @foreach($messages as $m)

                    <div class="flex {{ $m->sender_id == $authId ? 'justify-end' : 'justify-start' }}">

                        <div class="
                            px-4 py-2 rounded-2xl text-sm max-w-xs shadow
                            {{ $m->sender_id == $authId
                                ? 'bg-gradient-to-r from-indigo-500 to-blue-500 text-white rounded-br-none'
                                : 'bg-white text-slate-700 border rounded-bl-none'
                            }}
                        ">

                            {{ $m->message }}

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- ================= INPUT ================= --}}
            <form action="{{ route('messages.send') }}" method="POST"
                  class="p-3 border-t bg-white flex gap-2">

                @csrf
                <input type="hidden" name="receiver_id" value="{{ $partner->id }}">

                <input name="message" required
                    class="flex-1 border rounded-full px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none"
                    placeholder="Ketik pesan...">

                <button
                    class="bg-gradient-to-r from-indigo-500 to-blue-500 hover:opacity-90 text-white px-6 py-2 rounded-full text-sm font-semibold shadow">
                    Kirim
                </button>

            </form>

        @else

            {{-- EMPTY CHAT --}}
            <div class="flex-1 flex items-center justify-center text-slate-400">

                <div class="text-center">

                    <div class="text-6xl mb-4 opacity-70">💬</div>

                    <p class="text-xl font-semibold text-slate-600">
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
