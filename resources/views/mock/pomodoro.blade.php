<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-orange-500/20 text-orange-400 flex items-center justify-center border border-orange-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-outfit font-bold text-2xl text-white leading-tight">
                    Pomodoro Timer
                </h2>
                <p class="text-sm text-gray-400 mt-1">Timer fokus yang bisa langsung dipakai, lengkap dengan sesi fokus dan jeda otomatis.</p>
            </div>
        </div>
    </x-slot>

    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute inset-0 bg-gray-950"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1542382156909-92371910d540?q=80&w=2675&auto=format&fit=crop')] opacity-10 bg-cover bg-center"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-orange-600/10 rounded-full blur-[100px] pointer-events-none"></div>
    </div>

    <div
        x-data="pomodoroTimer()"
        x-init="init()"
        class="max-w-5xl mx-auto py-8 relative z-10 flex flex-col lg:flex-row gap-8 items-start justify-center min-h-[calc(100vh-180px)]"
    >
        <div class="w-full lg:w-2/3 glass-panel rounded-[3rem] p-8 md:p-12 text-center border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)]">
            <div class="inline-flex flex-wrap justify-center bg-gray-900 rounded-full p-1 mb-10 border border-white/5 gap-1">
                <button
                    type="button"
                    @click="selectMode('focus')"
                    :class="mode === 'focus' ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition"
                >
                    Fokus
                </button>
                <button
                    type="button"
                    @click="selectMode('shortBreak')"
                    :class="mode === 'shortBreak' ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition"
                >
                    Istirahat Pendek
                </button>
                <button
                    type="button"
                    @click="selectMode('longBreak')"
                    :class="mode === 'longBreak' ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition"
                >
                    Istirahat Panjang
                </button>
            </div>

            <div class="relative w-72 h-72 mx-auto flex items-center justify-center">
                <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="4" />
                    <circle
                        cx="50"
                        cy="50"
                        r="45"
                        fill="none"
                        class="text-orange-500 transition-all duration-300"
                        stroke="currentColor"
                        stroke-width="4"
                        :stroke-dasharray="circleCircumference"
                        :stroke-dashoffset="progressStrokeOffset"
                        stroke-linecap="round"
                    />
                </svg>

                <div class="text-center">
                    <p class="text-xs uppercase tracking-[0.35em] text-orange-300/80 mb-3" x-text="currentModeLabel"></p>
                    <h1 class="font-outfit text-6xl md:text-7xl font-bold text-white tracking-tight" x-text="formattedTime"></h1>
                    <p class="text-sm text-gray-400 mt-3 px-6" x-text="currentModeDescription"></p>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap justify-center gap-3">
                <button
                    type="button"
                    @click="toggleTimer()"
                    class="inline-flex items-center gap-2 px-6 h-14 rounded-full bg-orange-500 text-white font-semibold shadow-lg shadow-orange-500/20 hover:bg-orange-400 transition"
                >
                    <svg x-show="!isRunning" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.5 5.5a1 1 0 011.53-.848l6 4a1 1 0 010 1.696l-6 4A1 1 0 016.5 13.5v-8z"></path>
                    </svg>
                    <svg x-show="isRunning" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6 5a1 1 0 011-1h1.5a1 1 0 011 1v10a1 1 0 01-1 1H7a1 1 0 01-1-1V5zm4.5 0a1 1 0 011-1H13a1 1 0 011 1v10a1 1 0 01-1 1h-1.5a1 1 0 01-1-1V5z"></path>
                    </svg>
                    <span x-text="primaryActionLabel"></span>
                </button>

                <button
                    type="button"
                    @click="resetTimer()"
                    class="inline-flex items-center justify-center px-6 h-14 rounded-full bg-white/5 text-gray-200 border border-white/10 hover:bg-white/10 transition"
                >
                    Reset
                </button>

                <button
                    type="button"
                    @click="skipMode()"
                    class="inline-flex items-center justify-center px-6 h-14 rounded-full bg-white/5 text-gray-200 border border-white/10 hover:bg-white/10 transition"
                >
                    Lewati
                </button>
            </div>

            <p class="text-sm text-gray-400 mt-6" x-text="notice"></p>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Sesi Fokus Hari Ini</p>
                    <p class="font-outfit text-3xl text-white mt-2" x-text="completedFocusSessions"></p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Target Harian</p>
                    <p class="font-outfit text-3xl text-white mt-2" x-text="`${cycleTarget} sesi`"></p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Long Break Lagi</p>
                    <p class="font-outfit text-3xl text-white mt-2" x-text="`${sessionsUntilLongBreak} sesi`"></p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/3 flex flex-col gap-4">
            <div class="glass-panel border border-white/10 rounded-[2rem] p-6">
                <h3 class="font-outfit font-bold text-xl text-white">Pengaturan Durasi</h3>
                <p class="text-sm text-gray-400 mt-1">Durasi disimpan di browser, jadi timer tetap lanjut saat halaman direfresh.</p>

                <div class="mt-6 space-y-4">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-300">Fokus</span>
                        <div class="mt-2 flex items-center gap-3">
                            <input
                                type="number"
                                min="10"
                                max="90"
                                x-model.number="durations.focus"
                                @change="updateDuration('focus', durations.focus)"
                                class="w-full rounded-2xl border border-white/10 bg-gray-900/70 px-4 py-3 text-white focus:border-orange-400 focus:outline-none"
                            >
                            <span class="text-sm text-gray-400">menit</span>
                        </div>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-gray-300">Istirahat Pendek</span>
                        <div class="mt-2 flex items-center gap-3">
                            <input
                                type="number"
                                min="1"
                                max="30"
                                x-model.number="durations.shortBreak"
                                @change="updateDuration('shortBreak', durations.shortBreak)"
                                class="w-full rounded-2xl border border-white/10 bg-gray-900/70 px-4 py-3 text-white focus:border-orange-400 focus:outline-none"
                            >
                            <span class="text-sm text-gray-400">menit</span>
                        </div>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-gray-300">Istirahat Panjang</span>
                        <div class="mt-2 flex items-center gap-3">
                            <input
                                type="number"
                                min="5"
                                max="60"
                                x-model.number="durations.longBreak"
                                @change="updateDuration('longBreak', durations.longBreak)"
                                class="w-full rounded-2xl border border-white/10 bg-gray-900/70 px-4 py-3 text-white focus:border-orange-400 focus:outline-none"
                            >
                            <span class="text-sm text-gray-400">menit</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="glass-panel border border-white/10 rounded-[2rem] p-6">
                <h3 class="font-outfit font-bold text-xl text-white">Progres Hari Ini</h3>
                <div class="mt-5 rounded-full bg-white/5 h-3 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-amber-400 transition-all duration-300" :style="`width: ${dailyProgressPercent}%`"></div>
                </div>
                <p class="text-sm text-gray-400 mt-3">
                    <span class="text-white font-semibold" x-text="completedFocusSessions"></span>
                    dari
                    <span class="text-white font-semibold" x-text="cycleTarget"></span>
                    sesi fokus selesai hari ini.
                </p>

                <div class="mt-6 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-gray-400">Mode aktif</span>
                        <span class="text-white font-medium" x-text="currentModeLabel"></span>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-gray-400">Status</span>
                        <span class="text-white font-medium" x-text="isRunning ? 'Sedang berjalan' : 'Siap digunakan'"></span>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-gray-400">Penyimpanan</span>
                        <span class="text-white font-medium">Browser lokal</span>
                    </div>
                </div>
            </div>

            <div class="glass-panel border border-white/10 rounded-[2rem] p-6">
                <h3 class="font-outfit font-bold text-xl text-white">Cara Pakai Cepat</h3>
                <ol class="mt-4 space-y-3 text-sm text-gray-300 list-decimal list-inside">
                    <li>Pilih mode fokus atau istirahat sesuai kebutuhan.</li>
                    <li>Tekan tombol mulai untuk menjalankan countdown.</li>
                    <li>Setelah sesi selesai, mode berikutnya akan disiapkan otomatis.</li>
                </ol>
            </div>
        </div>
    </div>
</x-app-layout>
