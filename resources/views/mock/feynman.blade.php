<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center border border-purple-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
            </div>
            <div>
                <h2 class="font-outfit font-bold text-2xl text-white leading-tight">
                    Simulator Teknik Feynman
                </h2>
                <p class="text-sm text-gray-400 mt-1">Jelaskan materi seolah-olah kamu mengajarinya kepada anak kecil.</p>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-140px)]">
        
        <!-- Left: User Explanation Area -->
        <div class="flex-1 flex flex-col gap-4 min-h-[400px]">
            <div class="bg-gray-900/60 border border-white/5 rounded-2xl p-4 flex items-center justify-between">
                <div>
                    <h3 class="text-white font-medium">Topik: <span class="text-purple-400">Proklamasi Kemerdekaan RI</span></h3>
                </div>
                <button class="px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-lg text-white text-sm font-medium transition shadow-[0_0_15px_rgba(168,85,247,0.3)]">Minta Evaluasi AI</button>
            </div>
            
            <div class="flex-1 glass-panel border border-white/5 rounded-2xl p-6 relative">
                <textarea class="w-full h-full bg-transparent border-0 text-gray-300 text-lg leading-relaxed focus:ring-0 resize-none font-inter custom-scrollbar" placeholder="Ketik penjelasanmu di sini... (Contoh: Kemerdekaan Indonesia itu diibaratkan seperti...)">Jadi kemerdekaan Indonesia itu terjadi karena ada vacuum of power. Pada tanggal 16 Agustus 1945, golongan muda membawa Soekarno ke Rengasdengklok dengan tujuan agar tidak ter-intervensi oleh Jepang. Lalu keesokan harinya mereka memproklamasikannya.</textarea>
            </div>
        </div>

        <!-- Right: AI Evaluator Area -->
        <div class="w-full lg:w-96 flex flex-col gap-4">
            
            <div class="glass-panel border border-white/5 rounded-2xl p-6 h-full flex flex-col relative overflow-hidden">
                <div class="absolute -right-10 top-0 w-32 h-32 bg-pink-500/10 blur-3xl rounded-full pointer-events-none"></div>

                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10 relative z-10">
                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-xl">🧐</div>
                    <div>
                        <h4 class="font-bold text-white">AI Evaluator</h4>
                        <p class="text-[10px] text-green-400 uppercase tracking-widest font-bold">Menganalisis...</p>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto space-y-5 relative z-10 custom-scrollbar pr-2">
                    
                    <!-- Feedback Item 1: Jargon -->
                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                        <div class="flex items-start gap-2 mb-2">
                            <svg class="w-4 h-4 text-red-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <h5 class="text-sm font-bold text-red-300">Jargon Terdeteksi</h5>
                        </div>
                        <p class="text-sm text-gray-300">
                            Kamu menggunakan kata <span class="bg-red-500/20 px-1 text-red-200 rounded">vacuum of power</span> dan <span class="bg-red-500/20 px-1 text-red-200 rounded">intervensi</span>. Bisakah kamu menjelaskan apa arti kedua kata itu seolah menjelaskan ke anak SMP?
                        </p>
                    </div>

                    <!-- Feedback Item 2: Gap -->
                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                        <div class="flex items-start gap-2 mb-2">
                            <svg class="w-4 h-4 text-blue-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h5 class="text-sm font-bold text-blue-300">Lubang Pemahaman</h5>
                        </div>
                        <p class="text-sm text-gray-300">
                            Kamu melompat dari "Rengasdengklok" langsung ke "memproklamasikannya". Apa yang terjadi di malam tanggal 16 Agustus di rumah Laksamana Maeda?
                        </p>
                    </div>

                    <!-- Feedback Item 3: Praise -->
                    <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4">
                        <div class="flex items-start gap-2 mb-2">
                            <svg class="w-4 h-4 text-green-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h5 class="text-sm font-bold text-green-300">Alur yang Bagus</h5>
                        </div>
                        <p class="text-sm text-gray-300">
                            Penyampaian bahwa "Golongan muda membawa Soekarno... agar tidak terpengaruh Jepang" sudah sangat lurus dan mudah dimengerti tujuannya.
                        </p>
                    </div>

                </div>

            </div>
        </div>

    </div>
</x-app-layout>
