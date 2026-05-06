<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-fuchsia-100/90">Study Roulette</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">Cari Partner Secepat Mungkin</h2>
            <p class="mt-2 text-sm text-slate-300/80">Mode ini dibuat seperti antrean cepat. Tidak pakai topik wajib, fokusnya masuk, match, ngobrol, lalu next kalau perlu.</p>
        </div>
    </x-slot>

    @php($partner = $activeMatch?->partnerFor(auth()->user()))

    <div class="space-y-6">
        <section class="feature-hero">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="user-kicker text-[11px] text-fuchsia-100/90">Quick Match</p>
                    <h3 class="mt-3 font-outfit text-2xl font-semibold text-white">Masuk antrean, temukan partner, lanjutkan atau lompat ke partner berikutnya.</h3>
                    <p class="mt-3 text-sm text-slate-100/80">Alur ini saya pisahkan dari matchmaking biasa supaya experience-nya terasa seperti mode game lobby, bukan formulir cari teman.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if ($activeMatch)
                        <form method="POST" action="{{ route('matchmaking.roulette.next') }}">
                            @csrf
                            <button class="inline-flex h-12 items-center justify-center rounded-2xl border border-cyan-400/20 bg-cyan-400/10 px-5 text-sm font-semibold text-cyan-100 transition hover:bg-cyan-400/15">Next</button>
                        </form>
                        <form method="POST" action="{{ route('matchmaking.roulette.stop') }}">
                            @csrf
                            <button class="inline-flex h-12 items-center justify-center rounded-2xl border border-rose-400/20 bg-rose-400/10 px-5 text-sm font-semibold text-rose-100 transition hover:bg-rose-400/15">Stop</button>
                        </form>
                    @elseif ($queue)
                        <form method="POST" action="{{ route('matchmaking.roulette.stop') }}">
                            @csrf
                            <button class="inline-flex h-12 items-center justify-center rounded-2xl border border-rose-400/20 bg-rose-400/10 px-5 text-sm font-semibold text-rose-100 transition hover:bg-rose-400/15">Stop Search</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('matchmaking.roulette.start') }}">
                            @csrf
                            <button class="user-primary-button inline-flex h-12 items-center justify-center px-5 text-sm font-semibold">Start Roulette</button>
                        </form>
                    @endif
                </div>
            </div>
        </section>

        @if (session('status'))
            <div class="rounded-2xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">{{ $errors->first() }}</div>
        @endif

        @if ($activeMatch)
            <div
                x-data="matchChat({
                    initialMessages: {{ \Illuminate\Support\Js::from(
                        $activeMatch->messages
                            ->map(fn ($message) => \App\Support\RealtimePayloads::matchMessage($message))
                            ->values()
                    ) }},
                    sendUrl: '{{ route('matches.messages.store', $activeMatch) }}',
                    pollUrl: '{{ route('matches.messages.index', $activeMatch) }}',
                    typingUrl: '{{ route('matches.typing', $activeMatch) }}',
                    channelName: 'match.{{ $activeMatch->id }}',
                    currentUserId: {{ auth()->id() }},
                    currentUserName: {{ \Illuminate\Support\Js::from(auth()->user()->name) }},
                })"
                class="grid gap-6 xl:grid-cols-[minmax(0,1.2fr)_360px]"
            >
                <section class="glass-panel accent-card-pink rounded-[1.75rem] p-5 md:p-6">
                    <div class="flex flex-col gap-3 border-b border-white/10 pb-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="user-kicker text-[11px] text-fuchsia-100/90">Live Match</p>
                            <h3 class="mt-2 font-outfit text-xl font-semibold text-white">{{ $partner?->name ?? 'Partner tidak tersedia' }}</h3>
                            <p class="mt-1 text-sm text-slate-300/70">{{ $partner?->studyProfile?->primary_subject ?? 'Partner belum isi mapel utama' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/45 px-4 py-3 text-xs text-slate-300/70">
                            <span x-text="connectionState"></span>
                        </div>
                    </div>

                    <div x-ref="messageList" class="mt-5 max-h-[32rem] space-y-4 overflow-y-auto pr-1">
                        <div x-show="!booted" class="space-y-4">
                            @forelse ($activeMatch->messages as $message)
                                <div class="{{ $message->user_id === auth()->id() ? 'ml-auto bg-fuchsia-500/16 border-fuchsia-200/20' : 'mr-auto bg-white/[0.06] border-white/10' }} max-w-full md:max-w-3xl rounded-2xl border p-4">
                                    <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">{{ $message->user->name }}</p>
                                    <p class="break-words whitespace-pre-line text-sm leading-7 text-slate-100">{{ $message->content }}</p>
                                </div>
                            @empty
                                <div class="text-sm text-slate-300/70">Belum ada pesan. Buka dengan sapaan singkat dan tujuan belajar hari ini.</div>
                            @endforelse
                        </div>

                        <div x-cloak x-show="booted" class="space-y-4">
                            <template x-if="messages.length === 0">
                                <div class="text-sm text-slate-300/70">Belum ada pesan. Buka dengan sapaan singkat dan tujuan belajar hari ini.</div>
                            </template>

                            <template x-for="message in messages" :key="message.id">
                                <div :class="`${bubbleClasses(message, currentUserId)} max-w-full md:max-w-3xl rounded-2xl border p-4`">
                                    <p class="mb-2 text-xs uppercase tracking-wide text-slate-400" x-text="message.user_name"></p>
                                    <p class="break-words whitespace-pre-line text-sm leading-7 text-slate-100" x-text="message.content"></p>
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

                    <form action="{{ route('matches.messages.store', $activeMatch) }}" method="POST" class="mt-5 space-y-4" @submit.prevent="submitMessage">
                        @csrf
                        <textarea x-model="form.content" @input="notifyTyping" name="content" rows="4" class="glass-input min-h-[120px] w-full px-4 py-3" required></textarea>
                        <div x-cloak x-show="error" class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200" x-text="error"></div>
                        <div class="flex flex-wrap gap-3">
                            <button class="user-primary-button inline-flex w-full px-6 py-3 disabled:opacity-60 sm:w-auto" :disabled="isSubmitting">
                                <span x-text="isSubmitting ? 'Mengirim...' : 'Kirim'"></span>
                            </button>
                        </div>
                    </form>
                </section>

                <aside class="glass-panel accent-card-violet rounded-[1.75rem] p-5 md:p-6">
                    <div>
                        <p class="user-kicker text-[11px] text-fuchsia-100/90">Partner Snapshot</p>
                        <h3 class="mt-2 font-outfit text-xl font-semibold text-white">{{ $partner?->name ?? 'Partner tidak tersedia' }}</h3>
                        <p class="mt-1 text-sm text-slate-300/70">{{ $partner?->studyProfile?->education_level ?? 'Jenjang belum diisi' }}</p>
                    </div>

                    <div class="mt-5 space-y-3">
                        <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Subjek utama</p>
                            <p class="mt-2 text-sm text-white">{{ $partner?->studyProfile?->primary_subject ?? 'Belum ada data' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Goal</p>
                            <p class="mt-2 text-sm text-white">{{ $partner?->studyProfile?->goal ?? 'Belum ada data' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Bio</p>
                            <p class="mt-2 break-words text-sm leading-6 text-slate-300/80">{{ $partner?->studyProfile?->bio ?? 'Belum ada bio' }}</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-3">
                        <form method="POST" action="{{ route('matchmaking.roulette.next') }}">
                            @csrf
                            <button class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-cyan-400/20 bg-cyan-400/10 px-5 text-sm font-semibold text-cyan-100 transition hover:bg-cyan-400/15">Next</button>
                        </form>
                        <form method="POST" action="{{ route('matchmaking.roulette.stop') }}">
                            @csrf
                            <button class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-rose-400/20 bg-rose-400/10 px-5 text-sm font-semibold text-rose-100 transition hover:bg-rose-400/15">Stop</button>
                        </form>
                        <form method="POST" action="{{ route('matches.block', $activeMatch) }}">
                            @csrf
                            <button class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-white/10 bg-white/[0.04] px-5 text-sm font-medium text-white transition hover:bg-white/[0.08]">Block Partner</button>
                        </form>
                    </div>
                </aside>
            </div>
        @else
            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
                <section class="glass-panel accent-card-pink rounded-[1.75rem] p-5 md:p-6">
                    <div class="space-y-5">
                        <div>
                            <p class="user-kicker text-[11px] text-fuchsia-100/90">Queue State</p>
                            <h3 class="mt-2 font-outfit text-2xl font-semibold text-white">{{ $queue ? 'Sedang mencari partner' : 'Belum masuk antrean' }}</h3>
                            <p class="mt-2 text-sm text-slate-300/75">
                                @if ($queue)
                                    Sistem sedang mencari pengguna lain yang juga masuk ke quick-match queue.
                                @else
                                    Masuk ke antrean cepat untuk bertemu partner belajar baru tanpa mengisi topik wajib.
                                @endif
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Mode</p>
                                <p class="mt-2 text-sm text-white">Quick Match</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Kuota</p>
                                <p class="mt-2 text-sm text-white">{{ auth()->user()->match_credits }} tersisa</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4">
                                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">Queue</p>
                                <p class="mt-2 text-sm text-white">{{ $queue ? optional($queue->expires_at)->format('H:i') : 'Idle' }}</p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-slate-950/45 p-4 text-sm leading-6 text-slate-300/80">
                            Pastikan profil matchmaking aktif. Sistem tetap memakai blokir user dan kuota plan yang sudah ada.
                        </div>

                        @if ($queue)
                            <form method="POST" action="{{ route('matchmaking.roulette.stop') }}">
                                @csrf
                                <button class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-rose-400/20 bg-rose-400/10 px-5 text-sm font-semibold text-rose-100 transition hover:bg-rose-400/15 sm:w-auto">Stop Search</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('matchmaking.roulette.start') }}">
                                @csrf
                                <button class="user-primary-button inline-flex h-12 w-full items-center justify-center px-5 text-sm font-semibold sm:w-auto">Start Roulette</button>
                            </form>
                        @endif
                    </div>
                </section>

                <aside class="glass-panel accent-card-violet rounded-[1.75rem] p-5 md:p-6">
                    <p class="user-kicker text-[11px] text-fuchsia-100/90">Mode Rules</p>
                    <div class="mt-4 space-y-3 text-sm leading-6 text-slate-300/80">
                        <p>Tekan `Start` untuk masuk antrean.</p>
                        <p>Tekan `Next` untuk menutup partner sekarang dan langsung mencari partner baru.</p>
                        <p>Tekan `Stop` untuk keluar dari antrean atau menutup sesi aktif.</p>
                    </div>
                    <a href="{{ route('matchmaking.index') }}" class="mt-5 inline-flex h-11 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.04] px-4 text-sm font-medium text-white transition hover:bg-white/[0.08]">Kembali ke Matchmaking</a>
                </aside>
            </div>
        @endif
    </div>
</x-app-layout>
