<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-violet-200/90">AI Tutor Thread</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">{{ $thread->title }}</h2>
            <p class="mt-2 text-sm text-slate-300/80">{{ $thread->material?->title ?? 'Thread umum tanpa materi' }}</p>
        </div>
    </x-slot>
    <div
        x-data="threadChat({
            initialMessages: {{ \Illuminate\Support\Js::from(
                $thread->messages
                    ->map(fn ($message) => \App\Support\RealtimePayloads::threadMessage($message))
                    ->values()
            ) }},
            sendUrl: '{{ route('chat.messages.store', $thread) }}',
            pollUrl: '{{ route('chat.messages.index', $thread) }}',
            channelName: 'thread.{{ $thread->id }}',
            thread: {{ \Illuminate\Support\Js::from(\App\Support\RealtimePayloads::threadStatus($thread)) }},
        })"
        class="space-y-6"
    >
        @if (session('status'))
            <div class="rounded-2xl border border-green-500/30 bg-green-500/10 p-4 text-sm text-green-200">{{ session('status') }}</div>
        @endif

        <div x-cloak x-show="hasAiNotice" :class="aiStatusClasses" class="rounded-2xl border p-4 text-sm">
            <p x-text="aiStatusText"></p>
        </div>

        <section class="feature-hero">
            <div class="max-w-3xl">
                <p class="user-kicker text-[11px] text-violet-100/90">Context First</p>
                <p class="mt-3 text-sm text-slate-100/80">AI tetap menjawab dalam konteks thread ini, sehingga diskusi terasa lebih fokus saat kamu membedah satu materi atau satu pertanyaan spesifik.</p>
            </div>
        </section>

        <section class="glass-panel accent-card-violet rounded-[1.75rem] p-4 md:p-6 space-y-4">
            <div class="rounded-2xl border border-white/10 bg-slate-950/45 px-4 py-3 text-xs text-slate-300/70">
                <span x-text="connectionState"></span>
            </div>

            <div x-ref="messageList" class="max-h-[30rem] overflow-y-auto space-y-4 pr-1">
                <div x-show="!booted" class="space-y-4">
                    @forelse ($thread->messages as $message)
                        <div class="{{ $message->role === 'user' ? 'ml-auto bg-violet-500/18 border-violet-300/20' : 'mr-auto bg-white/[0.06] border-white/10' }} max-w-full md:max-w-3xl rounded-2xl border p-4">
                            <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">{{ $message->role }}</p>
                            <p class="text-sm leading-7 text-slate-100 whitespace-pre-line break-words">{{ $message->content }}</p>
                        </div>
                    @empty
                        <div class="text-sm text-slate-300/70">Belum ada pesan di thread ini.</div>
                    @endforelse
                </div>

                <div x-cloak x-show="booted" class="space-y-4">
                    <template x-if="messages.length === 0">
                        <div class="text-sm text-slate-300/70">Belum ada pesan di thread ini.</div>
                    </template>

                    <template x-for="message in messages" :key="message.id">
                        <div :class="`${bubbleClasses(message)} max-w-full md:max-w-3xl rounded-2xl border p-4`">
                            <p class="mb-2 text-xs uppercase tracking-wide text-slate-400" x-text="roleLabel(message)"></p>
                            <p class="text-sm leading-7 text-slate-100 whitespace-pre-line break-words" x-text="message.content"></p>
                        </div>
                    </template>

                    <div x-cloak x-show="isAiWorking" class="mr-auto max-w-full md:max-w-3xl rounded-2xl border border-white/10 bg-slate-900/70 p-4">
                        <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">AI Tutor</p>
                        <div class="flex items-center gap-2 text-sm leading-7 text-slate-100">
                            <span>AI sedang mengetik</span>
                            <span class="typing-dots" aria-hidden="true">
                                <span></span><span></span><span></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="glass-panel accent-card-cyan rounded-[1.75rem] p-4 sm:p-5 md:p-6">
            <form action="{{ route('chat.messages.store', $thread) }}" method="POST" class="space-y-4" @submit.prevent="submitMessage">
                @csrf
                <div>
                    <label class="mb-2 block text-sm text-slate-200">Pesan Baru</label>
                    <textarea x-model="form.content" name="content" rows="5" class="glass-input min-h-[140px] w-full px-4 py-3" required></textarea>
                    @unless (auth()->user()->isPremium())
                        <p class="mt-2 text-xs text-slate-300/55">
                            Akun free dibatasi {{ config('services.openai.limits.free_per_day', 10) }} pesan AI per hari dan {{ config('services.openai.limits.free_per_minute', 4) }} pesan per menit.
                        </p>
                    @endunless
                </div>
                <div x-cloak x-show="error" class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200" x-text="error"></div>
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('feature.chat') }}" class="text-sm text-slate-300/70">Kembali ke daftar thread</a>
                    <button type="submit" class="user-primary-button inline-flex w-full px-6 py-3 disabled:opacity-60 sm:w-auto" :disabled="isSubmitting || isAiWorking">
                        <span x-text="isSubmitting ? 'Mengirim...' : (isAiWorking ? 'Tunggu AI...' : 'Kirim')"></span>
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
