<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-violet-200/90">Learning Hub</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">Dashboard Belajar</h2>
            <p class="mt-2 max-w-2xl text-sm text-slate-300/80">Ringkasan AI tools, ruang kelas, dan study matching untuk akunmu dalam satu workspace yang lebih fokus dan enak dibaca.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <a href="{{ route('feature.upload') }}" class="user-primary-button w-full px-5 py-2.5 text-sm md:w-auto">Materi Baru</a>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
            <div class="glass-panel user-stat-card rounded-[1.75rem] p-5"><p class="user-kicker text-[10px] text-slate-300/75">Materi</p><p class="mt-3 font-roboto text-3xl font-bold text-white">{{ $materialCount }}</p></div>
            <div class="glass-panel user-stat-card rounded-[1.75rem] p-5"><p class="user-kicker text-[10px] text-slate-300/75">Ringkasan</p><p class="mt-3 font-roboto text-3xl font-bold text-white">{{ $summaryCount }}</p></div>
            <div class="glass-panel user-stat-card rounded-[1.75rem] p-5"><p class="user-kicker text-[10px] text-slate-300/75">Thread AI</p><p class="mt-3 font-roboto text-3xl font-bold text-white">{{ $threadCount }}</p></div>
            <div class="glass-panel user-stat-card rounded-[1.75rem] p-5"><p class="user-kicker text-[10px] text-slate-300/75">Room Kelas</p><p class="mt-3 font-roboto text-3xl font-bold text-white">{{ $roomCount }}</p></div>
            <div class="glass-panel user-stat-card rounded-[1.75rem] p-5"><p class="user-kicker text-[10px] text-slate-300/75">Match Aktif</p><p class="mt-3 font-roboto text-3xl font-bold text-white">{{ $activeMatchCount }}</p></div>
        </div>

        <section class="glass-panel-strong user-highlight-ring flex flex-col gap-4 rounded-[1.75rem] p-5 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="user-kicker text-[11px] text-cyan-100">Plan {{ auth()->user()->plan }}</p>
                <p class="mt-3 text-lg font-semibold text-white">Sisa kuota study matching: {{ auth()->user()->match_credits }}</p>
                <p class="mt-1 text-sm text-slate-300/75">Upgrade premium untuk room lebih banyak, match tanpa batas, dan fitur sosial penuh.</p>
            </div>
            <a href="{{ route('pricing') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-white/15 bg-white/90 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-white md:w-auto">Lihat Pricing</a>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <section class="glass-panel overflow-hidden rounded-[1.75rem]">
                <div class="flex items-center justify-between border-b border-white/10 p-5">
                    <h3 class="font-outfit text-lg font-semibold text-white">Room Kelas</h3>
                    <a href="{{ route('rooms.index') }}" class="text-sm text-cyan-200">Buka room</a>
                </div>
                <div class="divide-y divide-white/10">
                    @forelse ($recentRooms as $room)
                        <a href="{{ route('rooms.show', $room) }}" class="block p-4 transition hover:bg-white/[0.06]">
                            <p class="text-white font-medium">{{ $room->name }}</p>
                            <p class="mt-1 text-sm text-slate-300/70">{{ $room->topic }} | {{ $room->members_count }} member</p>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-slate-300/70">Belum ikut room.</div>
                    @endforelse
                </div>
            </section>

            <section class="glass-panel overflow-hidden rounded-[1.75rem]">
                <div class="flex items-center justify-between border-b border-white/10 p-5">
                    <h3 class="font-outfit text-lg font-semibold text-white">Materi Terbaru</h3>
                    <a href="{{ route('materials.index') }}" class="text-sm text-cyan-200">Lihat semua</a>
                </div>
                <div class="divide-y divide-white/10">
                    @forelse ($recentMaterials as $material)
                        <a href="{{ route('materials.show', $material) }}" class="block p-4 transition hover:bg-white/[0.06]">
                            <p class="text-white font-medium">{{ $material->title }}</p>
                            <p class="mt-1 text-sm text-slate-300/70">{{ $material->status }} | {{ $material->summaries->count() }} ringkasan</p>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-slate-300/70">Belum ada materi.</div>
                    @endforelse
                </div>
            </section>

            <section class="glass-panel overflow-hidden rounded-[1.75rem]">
                <div class="flex items-center justify-between border-b border-white/10 p-5">
                    <h3 class="font-outfit text-lg font-semibold text-white">Thread AI</h3>
                    <a href="{{ route('feature.chat') }}" class="text-sm text-cyan-200">Buka chat</a>
                </div>
                <div class="divide-y divide-white/10">
                    @forelse ($recentThreads as $thread)
                        <a href="{{ route('chat.show', $thread) }}" class="block p-4 transition hover:bg-white/[0.06]">
                            <p class="text-white font-medium">{{ $thread->title }}</p>
                            <p class="mt-1 text-sm text-slate-300/70">{{ $thread->messages_count }} pesan | {{ $thread->material?->title ?? 'Tanpa materi' }}</p>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-slate-300/70">Belum ada thread chat.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
