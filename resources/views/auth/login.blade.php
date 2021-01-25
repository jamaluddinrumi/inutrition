<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <!-- replace this div below with your logo -->
            <div class="h-20"></div>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" onsubmit="onSubmit()">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full ring-1 ring-gray-300 bg-gray-50 bg-opacity-50" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full ring-1 ring-gray-300 bg-gray-50 bg-opacity-50" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4 cursor-pointer">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox rounded ring-1 ring-gray-300 cursor-pointer" name="remember">
                    <span class="ml-2 text-sm text-gray-600 cursor-pointer">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-jet-button id="submit-button" class="ml-4 font-bold rounded-full v-btn v-btn--contained v-btn--is-elevated v-btn--has-bg v-btn--rounded theme--light v-size--default elevation-1">
                    <span class="v-btn__content">
                        <i aria-hidden="true" class="v-icon notranslate mr-1 fas fa-sign-out-alt theme--light" style="font-size: 14px;"></i>
                        {{ __('Login') }}
                    </span>
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>