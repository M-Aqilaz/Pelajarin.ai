<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nalarin.ai - Platform Belajar AI untuk Siswa Indonesia</title>
        <link rel="icon" href="{{ asset('images/logo_nalarin_ai.png') }}" type="image/png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,600,700,800" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-outfit { font-family: 'Outfit', sans-serif; }
            .font-inter { font-family: 'Inter', sans-serif; }
            .glass-card {
                background: rgba(31, 41, 55, 0.4);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .gradient-text {
                background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            [x-cloak] { display: none !important; }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-16px); }
                100% { transform: translateY(0px); }
            }
            .blob {
                position: absolute;
                filter: blur(80px);
                z-index: -1;
                opacity: 0.4;
                border-radius: 50%;
            }
        </style>
    </head>
    <body x-data="{ mobileMenuOpen: false }" class="font-inter antialiased bg-gray-950 text-gray-100 overflow-x-hidden selection:bg-purple-500/30">
        <x-page-loader />
        <div class="blob bg-purple-600 h-96 w-96 -translate-x-1/2 -translate-y-1/2 top-0 left-0"></div>
        <div class="blob bg-blue-600 h-[30rem] w-[30rem] top-1/4 right-0 translate-x-1/3"></div>
        <div class="blob bg-indigo-600 h-80 w-80 bottom-0 left-1/4 translate-y-1/2"></div>

        <nav class="fixed top-0 z-50 w-full glass-card border-b-0 border-white/5">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between gap-4">
                    <div class="flex min-w-0 items-center gap-2">
                        <img src="{{ asset('images/logo_nalarin_ai.png') }}" class="h-8 w-8 object-contain" alt="Nalarin.ai Logo">
                        <span class="truncate font-outfit text-xl font-bold tracking-tight text-white sm:text-2xl">Nalarin<span class="text-purple-400">.ai</span></span>
                    </div>

                    <div class="hidden items-center space-x-8 md:flex">
                        <a href="#fitur" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Fitur</a>
                        <a href="{{ route('pricing') }}" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Harga</a>
                        <a href="#testimoni" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Testimoni</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="hidden rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-gray-950 shadow-[0_0_20px_rgba(255,255,255,0.2)] transition hover:bg-gray-200 sm:inline-flex">Mulai Belajar</a>
                        <button type="button" class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 p-2 text-gray-200 md:hidden" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen.toString()">
                            <svg x-show="!mobileMenuOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <svg x-cloak x-show="mobileMenuOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <div x-cloak x-show="mobileMenuOpen" x-transition class="border-t border-white/5 py-4 md:hidden">
                    <div class="flex flex-col gap-3">
                        <a href="#fitur" class="rounded-xl px-3 py-2 text-sm font-medium text-gray-200 hover:bg-white/5" @click="mobileMenuOpen = false">Fitur</a>
                        <a href="{{ route('pricing') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-gray-200 hover:bg-white/5" @click="mobileMenuOpen = false">Harga</a>
                        <a href="#testimoni" class="rounded-xl px-3 py-2 text-sm font-medium text-gray-200 hover:bg-white/5" @click="mobileMenuOpen = false">Testimoni</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-3 text-sm font-semibold text-gray-950">Mulai Belajar</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden pb-20 pt-28 sm:pt-32 lg:pb-32 lg:pt-40">
            <div class="relative z-10 mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-purple-500/30 bg-purple-500/10 px-3 py-1 text-xs font-medium text-purple-300">
                    <span class="relative flex h-2 w-2">
                      <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-purple-400 opacity-75"></span>
                      <span class="relative inline-flex h-2 w-2 rounded-full bg-purple-500"></span>
                    </span>
                    Nalarin.ai V2.0 Kini Tersedia
                </div>

                <h1 class="font-outfit mb-6 text-4xl font-extrabold leading-tight text-white sm:text-5xl md:text-6xl lg:text-7xl">
                    Transformasi Cara Belajarmu <br>
                    dengan <span class="gradient-text">Kecerdasan Buatan</span>
                </h1>

                <p class="mx-auto mb-10 mt-4 max-w-2xl text-base leading-relaxed text-gray-400 sm:text-lg md:text-xl">
                    Satu platform untuk semua kebutuhan belajarmu. Upload materi apapun, dapatkan ringkasan, flashcard, dan kuis dalam sekejap tanpa repot.
                </p>

                <div class="flex flex-col justify-center gap-4 sm:flex-row">
                    <a href="{{ route('login') }}" class="rounded-full bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-4 text-lg font-semibold text-white transition-all duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(168,85,247,0.4)]">
                        Mulai Belajar Sekarang
                    </a>
                    <a href="#fitur" class="flex items-center justify-center gap-2 rounded-full border border-gray-600 bg-gray-800/50 px-8 py-4 text-lg font-semibold text-white transition-all duration-300 hover:bg-gray-700/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lihat Demo
                    </a>
                </div>

                <div class="relative mx-auto mt-14 max-w-5xl animate-float sm:mt-20">
                    <div class="absolute inset-0 z-10 bg-gradient-to-t from-gray-950 via-transparent to-transparent"></div>
                    <div class="glass-card relative overflow-hidden rounded-2xl border border-white/10 p-2 shadow-2xl md:rounded-[2rem]">
                        <div class="flex gap-2 border-b border-white/5 bg-white/5 px-4 py-3">
                            <div class="h-3 w-3 rounded-full bg-red-500"></div>
                            <div class="h-3 w-3 rounded-full bg-yellow-500"></div>
                            <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="aspect-video rounded-b-xl bg-gray-900 bg-cover bg-center opacity-80" style="background-image: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop');">
                            <div class="flex h-full w-full items-center justify-center bg-gray-900/60 p-6 backdrop-blur-sm sm:p-8">
                                <div class="text-center">
                                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl border border-purple-500/50 bg-purple-500/20">
                                        <svg class="h-8 w-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <h3 class="font-outfit text-xl font-bold text-white sm:text-2xl">AI Sedang Menyusun Ringkasan...</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <section id="fitur" class="relative z-10 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-16 max-w-3xl text-center">
                    <h2 class="font-outfit mb-4 text-3xl font-bold text-white md:text-5xl">Belajar Lebih Cerdas, Bukan Lebih Keras</h2>
                    <p class="text-lg text-gray-400">Semua alat yang kamu butuhkan untuk memahami materi dengan cepat dan menyenangkan.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="glass-card rounded-3xl p-8 transition-transform duration-300 group hover:-translate-y-2">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-500/20 bg-blue-500/10 transition-colors group-hover:bg-blue-500/20">
                            <svg class="h-7 w-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="font-outfit mb-3 text-xl font-bold text-white">Ringkasan Otomatis</h3>
                        <p class="text-sm leading-relaxed text-gray-400">Ubah dokumen ratusan halaman menjadi poin-poin penting yang mudah dipahami dalam hitungan detik.</p>
                    </div>

                    <div class="glass-card rounded-3xl p-8 transition-transform duration-300 group hover:-translate-y-2">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl border border-purple-500/20 bg-purple-500/10 transition-colors group-hover:bg-purple-500/20">
                            <svg class="h-7 w-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h3 class="font-outfit mb-3 text-xl font-bold text-white">AI Tutor 24/7</h3>
                        <p class="text-sm leading-relaxed text-gray-400">Tanyakan apa saja tentang materimu. AI kami siap menjelaskan konsep sulit kapan saja layaknya guru pribadi.</p>
                    </div>

                    <div class="glass-card rounded-3xl p-8 transition-transform duration-300 group hover:-translate-y-2">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl border border-pink-500/20 bg-pink-500/10 transition-colors group-hover:bg-pink-500/20">
                            <svg class="h-7 w-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="font-outfit mb-3 text-xl font-bold text-white">Smart Flashcards</h3>
                        <p class="text-sm leading-relaxed text-gray-400">Hafalkan istilah penting dengan metode Spaced Repetition yang dibuktikan secara ilmiah efektif.</p>
                    </div>

                    <div class="glass-card rounded-3xl p-8 transition-transform duration-300 group hover:-translate-y-2">
                        <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl border border-green-500/20 bg-green-500/10 transition-colors group-hover:bg-green-500/20">
                            <svg class="h-7 w-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit mb-3 text-xl font-bold text-white">Interactive Quiz</h3>
                        <p class="text-sm leading-relaxed text-gray-400">Uji pemahamanmu dengan kuis pilihan ganda yang dibuat otomatis dari materi yang kamu pelajari.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="relative z-10 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-16 max-w-3xl text-center">
                    <h2 class="font-outfit mb-4 text-3xl font-bold text-white md:text-5xl">Dipakai dan Disukai Siswa</h2>
                    <p class="text-lg text-gray-400">Testimoni awal untuk memperkuat kepercayaan, positioning produk, dan konversi landing page.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article class="glass-card rounded-3xl p-8">
                        <div class="text-sm text-amber-300">★★★★★</div>
                        <p class="mt-5 leading-7 text-gray-200">
                            "Biasanya aku butuh waktu lama buat bikin rangkuman sendiri. Di Nalarin.ai, materi langsung jadi ringkasan dan flashcard, jadi belajar sebelum ujian jauh lebih cepat."
                        </p>
                        <div class="mt-6">
                            <p class="font-semibold text-white">Alya Ramadhani</p>
                            <p class="text-sm text-gray-400">Siswa SMA, Jakarta</p>
                        </div>
                    </article>

                    <article class="glass-card rounded-3xl p-8">
                        <div class="text-sm text-amber-300">★★★★★</div>
                        <p class="mt-5 leading-7 text-gray-200">
                            "Fitur quiz dan AI tutor-nya bikin aku nggak cuma baca materi, tapi benar-benar ngerti. Cocok buat persiapan presentasi dan tugas harian."
                        </p>
                        <div class="mt-6">
                            <p class="font-semibold text-white">Rizky Maulana</p>
                            <p class="text-sm text-gray-400">Mahasiswa Semester 3</p>
                        </div>
                    </article>

                    <article class="glass-card rounded-3xl p-8 md:col-span-2 xl:col-span-1">
                        <div class="text-sm text-amber-300">★★★★★</div>
                        <p class="mt-5 leading-7 text-gray-200">
                            "Anak-anak di komunitas belajar kami lebih aktif diskusi setelah pakai platform seperti ini. Materi lebih rapi, latihan lebih terarah, dan engagement naik."
                        </p>
                        <div class="mt-6">
                            <p class="font-semibold text-white">Dina Prasetyo</p>
                            <p class="text-sm text-gray-400">Mentor Komunitas Belajar</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="relative z-10 py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="glass-card relative overflow-hidden rounded-[2rem] border border-purple-500/20 bg-gradient-to-br from-purple-900/50 to-blue-900/50 p-8 text-center sm:p-12">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    <h2 class="relative z-10 font-outfit mb-6 text-3xl font-bold text-white md:text-5xl">Siap Revolusi Cara Belajarmu?</h2>
                    <p class="relative z-10 mx-auto mb-10 max-w-2xl text-lg text-purple-200 sm:text-xl">Gabung dengan ribuan siswa cerdas lainnya. Mulai gratis, upgrade kapan saja. Tidak perlu kartu kredit.</p>
                    <a href="{{ route('login') }}" class="relative z-10 inline-flex items-center justify-center rounded-full bg-white px-8 py-4 text-lg font-bold text-gray-900 shadow-[0_0_40px_rgba(255,255,255,0.3)] transition-all duration-300 hover:scale-105 hover:bg-gray-100">
                        Masuk Ruang Belajar
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <footer class="relative z-10 mt-10 border-t border-white/5 py-12">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 sm:px-6 lg:px-8 md:flex-row">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo_nalarin_ai.png') }}" class="h-6 w-6 object-contain" alt="Nalarin.ai Logo">
                    <span class="font-outfit text-xl font-bold tracking-tight text-white">Nalarin.ai</span>
                </div>
                <div class="text-center text-sm text-gray-500 md:text-left">
                    &copy; {{ date('Y') }} Nalarin.ai Clone. Built with Laravel + Tailwind.
                </div>
                <div class="flex flex-wrap items-center justify-center gap-4 text-sm md:justify-end">
                    <a href="#" class="text-gray-500 transition hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-500 transition hover:text-white">Syarat & Ketentuan</a>
                </div>
            </div>
        </footer>
    </body>
</html>
