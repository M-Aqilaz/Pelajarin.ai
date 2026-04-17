<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-outfit font-bold text-2xl text-white leading-tight">{{ $material->title }}</h2>
            <p class="text-sm text-gray-400 mt-1">Detail materi, ringkasan terkait, dan thread chat terkait.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-2xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200">{{ session('status') }}</div>
        @endif

        <section class="glass-panel rounded-2xl border border-white/5 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300">
                <div><span class="text-gray-500">Status:</span> {{ $material->status }}</div>
                <div><span class="text-gray-500">Pemilik:</span> {{ $material->user->name }}</div>
                <div><span class="text-gray-500">File:</span> {{ $material->original_filename ?? 'Tidak ada file' }}</div>
                <div><span class="text-gray-500">Ukuran:</span> {{ $material->file_size ? number_format($material->file_size) . ' bytes' : '-' }}</div>
            </div>
            <div class="mt-6">
                <h3 class="font-outfit text-lg font-semibold text-white mb-3">Teks Materi</h3>
                <div class="rounded-2xl bg-gray-900/70 border border-white/5 p-4 text-sm text-gray-300 whitespace-pre-line">{{ $material->raw_text ?: 'Belum ada teks materi.' }}</div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <section class="glass-panel rounded-2xl border border-white/5 overflow-hidden">
                <div class="p-5 border-b border-white/5 flex items-center justify-between">
                    <h3 class="font-outfit text-lg font-semibold text-white">Ringkasan</h3>
                    <a href="{{ route('feature.summary') }}" class="text-sm text-purple-400">Semua ringkasan</a>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse ($material->summaries as $summary)
                        <a href="{{ route('summaries.show', $summary) }}" class="block p-4 hover:bg-white/5 transition">
                            <p class="text-white font-medium">{{ $summary->title }}</p>
                            <p class="text-sm text-gray-400 mt-1">{{ \Illuminate\Support\Str::limit($summary->summary_text, 110) }}</p>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-gray-400">Belum ada ringkasan untuk materi ini.</div>
                    @endforelse
                </div>
            </section>

            <section class="glass-panel rounded-2xl border border-white/5 overflow-hidden">
                <div class="p-5 border-b border-white/5 flex items-center justify-between">
                    <h3 class="font-outfit text-lg font-semibold text-white">Thread Chat</h3>
                    <a href="{{ route('feature.chat') }}" class="text-sm text-purple-400">Buka chat</a>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse ($material->chatThreads as $thread)
                        <a href="{{ route('chat.show', $thread) }}" class="block p-4 hover:bg-white/5 transition">
                            <p class="text-white font-medium">{{ $thread->title }}</p>
                            <p class="text-sm text-gray-400 mt-1">{{ $thread->messages->count() }} pesan</p>
                        </a>
                    @empty
                        <div class="p-4 text-sm text-gray-400">Belum ada thread untuk materi ini.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
