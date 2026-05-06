<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-cyan-100/90">Activity Inbox</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">Notifikasi</h2>
            <p class="mt-2 text-sm text-slate-300/80">Ringkasan aktivitas terbaru dari AI tutor, room, dan study match dalam satu inbox yang lebih rapi.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="feature-hero">
            <div class="max-w-3xl">
                <p class="user-kicker text-[11px] text-cyan-100/90">Stay in Flow</p>
                <p class="mt-3 text-sm text-slate-100/80">Notifikasi penting tetap cepat dipindai, jadi kamu bisa langsung lompat ke materi, room, atau pasangan study match yang relevan.</p>
            </div>
        </section>

        <section class="glass-panel accent-card-cyan rounded-[1.75rem] p-5 md:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-outfit text-lg font-semibold text-white">Kotak Masuk</h3>
                    <p class="mt-1 text-sm text-slate-300/70">Klik notifikasi untuk membuka halaman terkait.</p>
                </div>
                @if (auth()->user()->unreadNotifications()->count() > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button class="rounded-xl border border-white/10 bg-white/[0.08] px-4 py-2.5 text-sm text-white">Tandai Semua Dibaca</button>
                    </form>
                @endif
            </div>
        </section>

        <section class="glass-panel accent-card-violet overflow-hidden rounded-[1.75rem]">
            <div class="divide-y divide-white/10">
                @forelse ($notifications as $notification)
                    @php($data = $notification->data)
                    <div class="{{ is_null($notification->read_at) ? 'bg-violet-500/6' : 'bg-transparent' }} p-5">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="text-white font-medium">{{ $data['title'] ?? 'Notifikasi' }}</h4>
                                    @if (is_null($notification->read_at))
                                        <span class="rounded-full border border-purple-400/30 bg-purple-500/10 px-2 py-0.5 text-[10px] uppercase tracking-[0.2em] text-purple-200">Baru</span>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm text-slate-100/85">{{ $data['body'] ?? 'Ada pembaruan baru untuk akun kamu.' }}</p>
                                @if (!empty($data['content']))
                                    <p class="mt-2 break-words text-sm text-slate-300/55">{{ $data['content'] }}</p>
                                @endif
                                <p class="mt-3 text-xs text-slate-300/50">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex flex-col gap-2 sm:flex-row md:shrink-0">
                                @if (!empty($data['url']))
                                    <a href="{{ $data['url'] }}" class="user-primary-button inline-flex items-center justify-center px-4 py-2.5 text-sm">Buka</a>
                                @endif
                                @if (is_null($notification->read_at))
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                        <button class="inline-flex w-full items-center justify-center rounded-xl border border-white/10 bg-white/[0.08] px-4 py-2.5 text-sm text-white">Tandai Dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-sm text-slate-300/70">Belum ada notifikasi untuk akun ini.</div>
                @endforelse
            </div>
        </section>

        <div>
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
