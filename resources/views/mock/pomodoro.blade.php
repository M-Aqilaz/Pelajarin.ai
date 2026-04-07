<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-orange-500/20 text-orange-400 flex items-center justify-center border border-orange-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h2 class="font-outfit font-bold text-2xl text-white leading-tight">
                    Ruang Fokus (Pomodoro)
                </h2>
                <p class="text-sm text-gray-400 mt-1">25 Menit fokus tinggi, 5 menit istirahat.</p>
            </div>
        </div>
    </x-slot>

    <!-- Ambient background effect -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute inset-0 bg-gray-950"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1542382156909-92371910d540?q=80&w=2675&auto=format&fit=crop')] opacity-10 bg-cover bg-center"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-orange-600/10 rounded-full blur-[100px] pointer-events-none"></div>
    </div>

    <div class="max-w-5xl mx-auto py-8 relative z-10 flex flex-col lg:flex-row gap-8 items-center justify-center min-h-[calc(100vh-180px)]">

        <!-- Timer Card -->
        <div class="w-full lg:w-2/3 glass-panel rounded-[3rem] p-12 text-center border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)]">
            <!-- Mode Toggle -->
            <div class="inline-flex bg-gray-900 rounded-full p-1 mb-12 border border-white/5">
                <button class="px-6 py-2 rounded-full bg-orange-500 text-white text-sm font-bold shadow-lg">Fokus</button>
                <button class="px-6 py-2 rounded-full text-gray-400 hover:text-white text-sm font-medium transition">Istirahat Pendek</button>
                <button class="px-6 py-2 rounded-full text-gray-400 hover:text-white text-sm font-medium transition">Istirahat Panjang</button>
            </div>

            <!-- Timer Circle -->
            <div class="relative w-72 h-72 mx-auto flex items-center justify-center">
                <!-- Circular Progress Mock -->
                <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="4" />
                    <!-- progress line -->
                    <circle cx="50" cy="50" r="45" fill="none" class="text-orange-500" stroke="currentColor" stroke-width="4" stroke-dasharray="283" stroke-dashoffset="60" stroke-linecap="round" />
                </svg>
                <h1 class="font-outfit text-7xl font-bold text-white tracking-tight">21:45</h1>
            </div>

            <!-- Actions -->
            <div class="mt-12 flex justify-center gap-4">
                <button class="w-16 h-16 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/30 flex items-center justify-center hover:bg-orange-500/30 hover:scale-105 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
                <button class="w-16 h-16 rounded-full bg-white/5 text-gray-400 border border-white/10 flex items-center justify-center hover:bg-white/10 hover:scale-105 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </button>
            </div>
            
            <p class="text-gray-500 text-sm mt-8">Sesi ke-2 dari 4 sesi fokus hari ini</p>
        </div>

        <!-- Ambience Sounds Sidebar -->
        <div class="w-full lg:w-1/3 flex flex-col gap-4">
            <h3 class="font-outfit font-bold text-xl text-white mb-2">Suara Latar (Ambience)</h3>
            
            <!-- Sound 1 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex items-center justify-between group hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-medium text-sm">Hujan Rintik-rintik</h4>
                        <p class="text-xs text-gray-400">Sedang diputar</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex gap-0.5 items-end h-4">
                        <div class="w-1 bg-blue-400 rounded-t h-4 animate-pulse [animation-delay:-0.2s]"></div>
                        <div class="w-1 bg-blue-400 rounded-t h-2 animate-pulse [animation-delay:-0.1s]"></div>
                        <div class="w-1 bg-blue-400 rounded-t h-3 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- Sound 2 -->
            <div class="bg-gray-900 border border-white/5 rounded-2xl p-4 flex items-center justify-between group hover:bg-white/5 transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-gray-300 font-medium text-sm">Api Unggun</h4>
                        <p class="text-xs text-gray-500">Berhenti</p>
                    </div>
                </div>
                <button class="text-gray-500 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
            </div>

            <!-- Sound 3 -->
            <div class="bg-gray-900 border border-white/5 rounded-2xl p-4 flex items-center justify-between group hover:bg-white/5 transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-gray-300 font-medium text-sm">Suasana Cafe</h4>
                        <p class="text-xs text-gray-500">Berhenti</p>
                    </div>
                </div>
                <button class="text-gray-500 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
            </div>
            
            <div class="mt-4 p-4 border border-white/5 bg-white/5 rounded-2xl">
                <label class="text-xs text-gray-400 block mb-2 font-medium">Volume Master</label>
                <input type="range" class="w-full accent-orange-500 bg-gray-700 h-1 rounded-full appearance-none outline-none" min="0" max="100" value="75">
            </div>

        </div>

    </div>
</x-app-layout>
