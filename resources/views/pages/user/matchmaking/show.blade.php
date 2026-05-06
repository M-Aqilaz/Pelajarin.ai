<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-fuchsia-100/90">Matched Session</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">Study Match</h2>
            <p class="mt-2 text-sm text-slate-300/80">Topik: {{ $match->topic }}</p>
        </div>
    </x-slot>

    @php($partner = $match->partnerFor(auth()->user()))

    <div
        x-data="matchChat({
            initialMessages: {{ \Illuminate\Support\Js::from(
                $match->messages
                    ->map(fn ($message) => \App\Support\RealtimePayloads::matchMessage($message))
                    ->values()
            ) }},
            sendUrl: '{{ route('matches.messages.store', $match) }}',
            pollUrl: '{{ route('matches.messages.index', $match) }}',
            typingUrl: '{{ route('matches.typing', $match) }}',
            channelName: 'match.{{ $match->id }}',
            currentUserId: {{ auth()->id() }},
            currentUserName: {{ \Illuminate\Support\Js::from(auth()->user()->name) }},
        })"
        class="space-y-6 lg:grid lg:grid-cols-[1.3fr_0.7fr] lg:gap-6 lg:space-y-0"
    >
        <section class="feature-hero lg:col-span-2">
            <div class="max-w-3xl">
                <p class="user-kicker text-[11px] text-fuchsia-100/90">Focused Pairing</p>
                <p class="mt-3 text-sm text-slate-100/80">Sesi ini dibuat khusus untuk diskusi dua orang, jadi tampilannya saya jaga tetap intimate dan ringan dibaca selama percakapan berjalan.</p>
            </div>
        </section>

        <section class="glass-panel accent-card-pink order-2 space-y-4 rounded-[1.75rem] p-5 md:p-6 lg:order-1">
            @if (session('status'))
                <div class="rounded-2xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200">{{ session('status') }}</div>
            @endif

            <div class="rounded-2xl border border-white/10 bg-slate-950/45 px-4 py-3 text-xs text-slate-300/70">
                <span x-text="connectionState"></span>
            </div>

            <div x-ref="messageList" class="max-h-[28rem] overflow-y-auto space-y-4 pr-1">
                <div x-show="!booted" class="space-y-4">
                    @forelse ($match->messages as $message)
                        <div class="{{ $message->user_id === auth()->id() ? 'ml-auto bg-fuchsia-500/16 border-fuchsia-200/20' : 'mr-auto bg-white/[0.06] border-white/10' }} max-w-full md:max-w-3xl rounded-2xl border p-4">
                            <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">{{ $message->user->name }}</p>
                            <p class="text-sm leading-7 text-slate-100 whitespace-pre-line break-words">{{ $message->content }}</p>
                        </div>
                    @empty
                        <div class="text-sm text-slate-300/70">Belum ada pesan dengan partner belajar ini.</div>
                    @endforelse
                </div>

                <div x-cloak x-show="booted" class="space-y-4">
                    <template x-if="messages.length === 0">
                        <div class="text-sm text-slate-300/70">Belum ada pesan dengan partner belajar ini.</div>
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

            <form action="{{ route('matches.messages.store', $match) }}" method="POST" class="space-y-4" @submit.prevent="submitMessage">
                @csrf
                <textarea x-model="form.content" @input="notifyTyping" name="content" rows="4" class="glass-input min-h-[120px] w-full px-4 py-3" required></textarea>
                <div x-cloak x-show="error" class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200" x-text="error"></div>
                <button class="user-primary-button inline-flex w-full px-6 py-3 disabled:opacity-60 sm:w-auto" :disabled="isSubmitting">
                    <span x-text="isSubmitting ? 'Mengirim...' : 'Kirim'"></span>
                </button>
            </form>
        </section>

        <aside class="glass-panel accent-card-violet order-1 space-y-4 rounded-[1.75rem] p-5 md:p-6 lg:order-2">
            <div>
                <p class="user-kicker text-[11px] text-fuchsia-100/90">Partner</p>
                <h3 class="font-outfit text-xl font-semibold text-white mt-2">{{ $partner?->name ?? 'Partner tidak tersedia' }}</h3>
                <p class="mt-1 text-sm text-slate-300/70">{{ $partner?->studyProfile?->primary_subject ?? 'Belum isi mapel utama' }}</p>
                <p class="mt-3 break-words text-sm text-slate-300/55">{{ $partner?->studyProfile?->bio }}</p>
            </div>
            <form method="POST" action="{{ route('matches.end', $match) }}">@csrf<button class="w-full rounded-xl border border-white/10 bg-white/[0.08] px-4 py-3 text-sm text-white">Akhiri Sesi</button></form>
            <form method="POST" action="{{ route('matches.block', $match) }}">@csrf<button class="w-full rounded-xl bg-red-500/10 px-4 py-3 text-sm text-red-200">Block Partner</button></form>
            <form method="POST" action="{{ route('matches.report', $match) }}" class="space-y-3">
                @csrf
                <textarea name="reason" rows="4" class="glass-input min-h-[120px] w-full px-4 py-3" placeholder="Alasan report" required></textarea>
                <button class="w-full rounded-xl bg-amber-500/10 px-4 py-3 text-sm text-amber-100">Laporkan</button>
            </form>
        </aside>
    </div>
</x-app-layout>
