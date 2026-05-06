<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-cyan-100/90">Room Live Chat</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">{{ $room->name }}</h2>
            <p class="mt-2 text-sm text-slate-300/80">{{ $room->topic }} | {{ $room->visibility }} | {{ $room->members->count() }} anggota</p>
        </div>
    </x-slot>

    <div
        x-data="roomChat({
            initialMessages: {{ \Illuminate\Support\Js::from(
                $messages
                    ->map(fn ($message) => \App\Support\RealtimePayloads::roomMessage($message))
                    ->values()
            ) }},
            sendUrl: '{{ route('rooms.messages.store', $room) }}',
            pollUrl: '{{ route('rooms.messages.index', $room) }}',
            typingUrl: '{{ route('rooms.typing', $room) }}',
            channelName: 'room.{{ $room->id }}',
            currentUserId: {{ auth()->id() }},
            currentUserName: {{ \Illuminate\Support\Js::from(auth()->user()->name) }},
        })"
        class="space-y-6 lg:grid lg:grid-cols-[1.4fr_0.6fr] lg:gap-6 lg:space-y-0"
    >
        <section class="feature-hero lg:col-span-2">
            <div class="max-w-3xl">
                <p class="user-kicker text-[11px] text-cyan-100/90">Shared Focus</p>
                <p class="mt-3 text-sm text-slate-100/80">Typing indicator, bubble realtime, dan daftar anggota sekarang duduk di atas tampilan glass yang lebih ringan dibaca dalam sesi diskusi panjang.</p>
            </div>
        </section>

        <section class="glass-panel accent-card-cyan order-2 space-y-4 rounded-[1.75rem] p-5 md:p-6 lg:order-1">
            @if (session('status'))
                <div class="rounded-2xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200">{{ session('status') }}</div>
            @endif

            <div class="rounded-2xl border border-white/10 bg-slate-950/45 px-4 py-3 text-xs text-slate-300/70">
                <span x-text="connectionState"></span>
            </div>

            <div x-ref="messageList" class="max-h-[28rem] overflow-y-auto space-y-4 pr-1">
                <div x-show="!booted" class="space-y-4">
                    @forelse ($messages as $message)
                        <div class="{{ $message->user_id === auth()->id() ? 'ml-auto bg-cyan-400/15 border-cyan-200/20' : 'mr-auto bg-white/[0.06] border-white/10' }} max-w-full md:max-w-3xl rounded-2xl border p-4">
                            <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">{{ $message->user->name }}</p>
                            <p class="text-sm leading-7 text-slate-100 whitespace-pre-line break-words">{{ $message->content }}</p>
                        </div>
                    @empty
                        <div class="text-sm text-slate-300/70">Belum ada pesan di room ini.</div>
                    @endforelse
                </div>

                <div x-cloak x-show="booted" class="space-y-4">
                    <template x-if="messages.length === 0">
                        <div class="text-sm text-slate-300/70">Belum ada pesan di room ini.</div>
                    </template>

                    <template x-for="message in messages" :key="message.id">
                        <div :class="`${bubbleClasses(message, currentUserId)} max-w-full md:max-w-3xl rounded-2xl border p-4`">
                            <p class="mb-2 text-xs uppercase tracking-wide text-slate-400" x-text="message.user_name"></p>
                            <p class="text-sm leading-7 text-slate-100 whitespace-pre-line break-words" x-text="message.content"></p>
                        </div>
                    </template>

                    <div x-cloak x-show="typingText" class="mr-auto max-w-full md:max-w-3xl rounded-2xl border border-white/10 bg-white/[0.06] p-4">
                        <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">Aktivitas</p>
                        <div class="flex items-center gap-3 text-sm text-slate-100">
                            <p class="leading-7" x-text="typingText"></p>
                            <span class="typing-dots" aria-hidden="true">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($isMember)
                <form action="{{ route('rooms.messages.store', $room) }}" method="POST" class="space-y-4" @submit.prevent="submitMessage">
                    @csrf
                    <textarea x-model="form.content" @input="notifyTyping" name="content" rows="4" class="glass-input min-h-[120px] w-full px-4 py-3" required></textarea>
                    <div x-cloak x-show="error" class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200" x-text="error"></div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <span class="text-xs text-slate-300/55">Kirim pesan ke seluruh anggota aktif room.</span>
                        <button type="submit" class="user-primary-button inline-flex w-full px-6 py-3 disabled:opacity-60 sm:w-auto" :disabled="isSubmitting">
                            <span x-text="isSubmitting ? 'Mengirim...' : 'Kirim'"></span>
                        </button>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ route('rooms.join', $room) }}" class="space-y-4">
                    @csrf
                    <div class="rounded-2xl border border-amber-500/20 bg-amber-500/10 p-4 text-sm text-amber-100">
                        Kamu bisa membaca percakapan room publik ini, tetapi harus join dulu untuk ikut mengirim pesan.
                    </div>
                    <button type="submit" class="user-primary-button inline-flex w-full px-6 py-3 sm:w-auto">Gabung Room</button>
                </form>
            @endif
        </section>

        <aside class="glass-panel accent-card-violet order-1 rounded-[1.75rem] p-5 md:p-6 lg:order-2">
            <div class="flex items-center justify-between gap-3">
                <h3 class="font-outfit text-lg font-semibold text-white">Anggota</h3>
                <form method="POST" action="{{ route('rooms.leave', $room) }}">@csrf<button class="text-sm text-red-300">Keluar</button></form>
            </div>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-1 max-h-[28rem] overflow-y-auto">
                @foreach ($room->members as $member)
                    @if ($member->status === 'active')
                        <div class="glass-panel rounded-xl p-3">
                            <p class="text-white text-sm font-medium">{{ $member->user->name }}</p>
                            <p class="mt-1 text-xs text-slate-300/65">{{ $member->role }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </aside>
    </div>
</x-app-layout>
