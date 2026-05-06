<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="user-kicker text-[11px] text-cyan-100/90">{{ __('Account Settings') }}</p>
            <h2 class="mt-2 font-outfit text-2xl font-bold leading-tight soft-gradient-text md:text-3xl">
                {{ __('Profile') }}
            </h2>
            <p class="mt-2 text-sm text-slate-300/80">Kelola identitas akun, keamanan, dan kontrol akses dari satu halaman yang lebih konsisten dengan tema workspace.</p>
        </div>
    </x-slot>

    <div class="space-y-6 py-4 md:py-6">
        <section class="feature-hero">
            <div class="max-w-3xl">
                <p class="user-kicker text-[11px] text-cyan-100/90">Control Center</p>
                <p class="mt-3 text-sm text-slate-100/80">Bagian profile sekarang saya samakan nadanya dengan dashboard user: gelap, glassy, tetap jelas saat mengubah data penting.</p>
            </div>
        </section>

        <div class="mx-auto max-w-7xl space-y-6 sm:px-2 lg:px-4">
            <div class="glass-panel accent-card-cyan rounded-[1.75rem] p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('pages.user.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="glass-panel accent-card-violet rounded-[1.75rem] p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('pages.user.profile.partials.update-password-form')
                </div>
            </div>

            <div class="glass-panel rounded-[1.75rem] p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('pages.user.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
