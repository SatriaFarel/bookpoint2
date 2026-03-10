<x-filament-panels::page>

    <div
        class="h-[80vh] bg-white dark:bg-gray-900 rounded-2xl border dark:border-gray-700 shadow-lg flex overflow-hidden">

        {{-- SIDEBAR --}}
        <div class="w-72 border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex flex-col">

            <div
                class="p-4 font-bold border-b border-gray-200 dark:border-gray-700 text-lg text-gray-800 dark:text-gray-200">
                Chat
            </div>

            <div class="overflow-y-auto flex-1">

                @foreach($chats as $c)

                    <a wire:click="loadChat({{ $c->id }})"
                        class="flex items-center gap-3 px-4 py-3 hover:bg-white dark:hover:bg-gray-800 transition border-b border-gray-200 dark:border-gray-700 cursor-pointer">

                        @if($c->foto)

                            <img src="{{ asset('storage/' . $c->foto) }}" class="w-11 h-11 rounded-full object-cover">

                        @else

                            <div
                                class="w-11 h-11 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($c->name, 0, 1)) }}
                            </div>

                        @endif

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ $c->name }}
                            </p>

                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                Klik untuk chat
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>


        {{-- CHAT ROOM --}}
        <div class="flex-1 flex flex-col bg-gray-50 dark:bg-gray-900">

            {{-- HEADER --}}
            <div
                class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3 bg-white dark:bg-gray-800">

                @if($partner)

                    @if($partner->foto)

                        <img src="{{ asset('storage/' . $partner->foto) }}" class="w-10 h-10 rounded-full object-cover">

                    @else

                        <div
                            class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($partner->name, 0, 1)) }}
                        </div>

                    @endif

                    <p class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ $partner->name }}
                    </p>

                @else

                    <p class="text-gray-400 dark:text-gray-500">
                        Pilih user untuk mulai chat
                    </p>

                @endif

            </div>


            {{-- MESSAGES --}}
            <div wire:poll.3s class="flex-1 p-6 overflow-y-auto space-y-3 bg-gray-50 dark:bg-gray-900">

                @if($partner)

                    @foreach($messages as $m)

                            <div class="flex {{ $m->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                                <div class="
                                    px-4 py-2
                                    rounded-2xl
                                    text-sm
                                    max-w-xs
                                    shadow
                                    {{ $m->sender_id == auth()->id()
                        ? 'bg-blue-600 text-white'
                        : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 border dark:border-gray-700'
                                    }}
                                ">

                                    {{ $m->message }}

                                </div>

                            </div>

                    @endforeach

                @else

                    <div class="flex items-center justify-center h-full text-gray-400 dark:text-gray-500">
                        Belum ada chat dipilih
                    </div>

                @endif

            </div>


            {{-- INPUT --}}
            @if($partner)

                <form wire:submit.prevent="sendMessage"
                    class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex gap-2">

                    <input wire:model.defer="messageText"
                        class="flex-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-full px-4 py-2 text-sm outline-none focus:ring focus:ring-blue-200"
                        placeholder="Ketik pesan...">

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full text-sm">

                        Kirim

                    </button>

                </form>

            @endif

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</x-filament-panels::page>