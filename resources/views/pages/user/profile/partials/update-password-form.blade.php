<section>
    <header>
        <h2 class="font-outfit text-xl font-semibold text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-slate-300/75">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-slate-200" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="glass-input mt-1 block w-full border-0 bg-transparent text-white" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-slate-200" />
            <x-text-input id="update_password_password" name="password" type="password" class="glass-input mt-1 block w-full border-0 bg-transparent text-white" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-slate-200" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="glass-input mt-1 block w-full border-0 bg-transparent text-white" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="user-primary-button px-5 py-2.5 text-sm">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-300/70"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
