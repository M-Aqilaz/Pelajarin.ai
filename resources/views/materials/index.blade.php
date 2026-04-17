<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-outfit font-bold text-2xl text-white leading-tight">Daftar Materi</h2>
            <p class="text-sm text-gray-400 mt-1">Semua materi yang tersimpan di database awal.</p>
        </div>
    </x-slot>

    <x-slot name="headerActions">
        <a href="{{ route('feature.upload') }}" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-medium text-sm transition">Tambah Materi</a>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($materials as $material)
            <a href="{{ route('materials.show', $material) }}" class="glass-panel rounded-2xl border border-white/5 p-5 hover:bg-white/5 transition block">
                <p class="text-lg font-outfit font-semibold text-white">{{ $material->title }}</p>
                <p class="text-sm text-gray-400 mt-2">Status: {{ $material->status }}</p>
                <p class="text-sm text-gray-400">{{ $material->summaries_count }} ringkasan • {{ $material->chat_threads_count }} thread</p>
            </a>
        @empty
            <div class="glass-panel rounded-2xl border border-white/5 p-5 text-sm text-gray-400 md:col-span-2 xl:col-span-3">Belum ada materi. Buat dari halaman upload.</div>
        @endforelse
    </div>
</x-app-layout>
