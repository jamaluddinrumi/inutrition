<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <!-- replace this div below with your logo -->
            <div class="h-20"></div>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full ring-1 ring-gray-300 bg-gray-50 bg-opacity-50" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button id="submit-button" class="ml-4 font-bold rounded-full v-btn v-btn--contained v-btn--is-elevated v-btn--has-bg v-btn--rounded theme--light v-size--default elevation-1">
                    <span class="v-btn__content">
                        <i aria-hidden="true" class="v-icon notranslate mr-1 fas fa-key theme--light" style="font-size: 14px;"></i>
                        {{ __('Reset Password') }}
                    </span>
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>