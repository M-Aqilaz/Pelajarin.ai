<aside class="glass-panel-strong z-20 hidden h-full w-64 shrink-0 flex-col border-r border-white/10 md:flex">
    <div class="flex h-20 items-center border-b border-white/10 px-6">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo_nalarin_ai.png') }}" class="w-8 h-8 object-contain" alt="Nalarin.ai Logo">
            <span class="flex gap-1 font-outfit text-xl font-bold tracking-tight soft-gradient-text">Nalarin.ai</span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('dashboard') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5.5v-6h-5v6H4a1 1 0 01-1-1v-9.5z"></path></svg>
            <span>Dashboard</span>
        </a>
        <div class="pt-4 pb-2"><p class="user-kicker px-3 text-[10px] font-semibold text-slate-400">AI Learning</p></div>
        <a href="{{ route('feature.upload') }}" data-feature="Unggah Materi" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.upload') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01.88-7.903A5.5 5.5 0 0118.5 9.5h.5a3.5 3.5 0 010 7H7zm5-8v9m0 0l-3-3m3 3l3-3"></path></svg>
            <span>Unggah Materi</span>
        </a>
        <a href="{{ route('feature.summary') }}" data-feature="Ringkasan Otomatis" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.summary') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 5.5h10M7 9.5h10M7 13.5h6M6 3h12a1 1 0 011 1v16l-3.5-2-3.5 2-3.5-2L5 20V4a1 1 0 011-1z"></path></svg>
            <span>Ringkasan</span>
        </a>
        <a href="{{ route('feature.chat') }}" data-feature="AI Tutor Khusus" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.chat') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5m-7 6l2.8-2H18a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h.5L6 20z"></path></svg>
            <span>AI Tutor</span>
        </a>
        <a href="{{ route('feature.flashcards') }}" data-feature="Smart Flashcards" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.flashcards') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h10a2 2 0 012 2v8H10a2 2 0 00-2 2V7zm0 0V5a2 2 0 00-2-2H4v14a2 2 0 012-2h2"></path></svg>
            <span>Flashcards</span>
        </a>
        <a href="{{ route('feature.quiz') }}" data-feature="Latihan Kuis" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.quiz') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.09 9a3 3 0 115.82 1c0 2-3 3-3 3m.09 4h.01M4 6.5l8-3 8 3v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9v-5z"></path></svg>
            <span>Kuis</span>
        </a>
        <div class="pt-4 pb-2"><p class="user-kicker px-3 text-[10px] font-semibold text-slate-400">Focus Section</p></div>
        <a href="{{ route('feature.pomodoro') }}" data-feature="Pomodoro Timer" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.pomodoro') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l2.5 2.5M12 21a8 8 0 100-16 8 8 0 000 16zm-3-18h6"></path></svg>
            <span>Pomodoro</span>
        </a>
        <a href="{{ route('feature.focus-planner') }}" data-feature="Focus Planner" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.focus-planner') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h8M8 12h8M8 17h5M6 3h12a1 1 0 011 1v16l-3-2-4 2-4-2-3 2V4a1 1 0 011-1z"></path></svg>
            <span>Focus Planner</span>
        </a>
        <a href="{{ route('feature.focus-insights') }}" data-feature="Focus Insights" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('feature.focus-insights') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19h16M7 16V9m5 7V5m5 11v-4"></path></svg>
            <span>Focus Insights</span>
        </a>
        <div class="pt-4 pb-2"><p class="user-kicker px-3 text-[10px] font-semibold text-slate-400">Social Learning</p></div>
        <a href="{{ route('rooms.index') }}" data-feature="Group Chat Kelas" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('rooms.*') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V10l-5-7-5 7v10h5m-5 0H7a2 2 0 01-2-2v-5m7 7v-4a2 2 0 00-2-2H8a2 2 0 00-2 2v4m0 0H2"></path></svg>
            <span>Group Chat Kelas</span>
        </a>
        <a href="{{ route('matchmaking.index') }}" data-feature="Study Matching" class="track-feature flex items-center gap-3 rounded-2xl px-3 py-3 {{ request()->routeIs('matchmaking.*', 'matches.*') ? 'user-highlight-ring bg-violet-500/15 text-violet-200 shadow-[0_14px_30px_rgba(76,29,149,0.18)]' : 'text-slate-300 hover:bg-white/[0.06] hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21s-6.5-4.35-8.5-8A4.9 4.9 0 014 6.7 4.8 4.8 0 017.6 5a4.7 4.7 0 014.4 2.7A4.7 4.7 0 0116.4 5 4.8 4.8 0 0120 6.7a4.9 4.9 0 01.5 6.3C18.5 16.65 12 21 12 21z"></path></svg>
            <span>Study Matching</span>
        </a>
    </nav>

    <div class="border-t border-white/10 p-4">
        <div class="space-y-3">
            <div class="rounded-2xl border border-white/10 bg-white/[0.06] p-3">
                <p class="text-xs font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                <p class="mt-2 text-[10px] uppercase text-violet-200">Plan {{ Auth::user()->plan }} | Match {{ Auth::user()->match_credits }}</p>
            </div>
            @if (Auth::user()->plan === 'free')
                <a href="{{ route('pricing') }}" class="block rounded-2xl border border-cyan-400/20 bg-cyan-400/10 p-3 transition-all hover:bg-cyan-400/15">
                    <p class="user-kicker text-[10px] text-cyan-100">Free Plan</p>
                    <p class="mt-2 text-sm font-semibold text-white">Upgrade to Pro</p>
                    <p class="mt-1 text-xs text-cyan-100/80">Buka limit room lebih besar, quota match lebih banyak, dan akses fitur premium.</p>
                </a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 text-xs text-slate-300 transition-all hover:bg-white/[0.06] hover:text-white">Profil Saya</a>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-3 py-2 text-xs text-slate-300 transition-all hover:bg-white/[0.06] hover:text-white">Admin Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-xs text-rose-300 transition-all hover:bg-rose-500/10 hover:text-rose-200">Keluar</button>
            </form>
        </div>
    </div>
</aside>
