<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <!-- replace this div below with your logo -->
            <div class="h-20"></div>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full ring-1 ring-gray-300 bg-gray-50 bg-opacity-50" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button id="submit-button" class="ml-4 font-bold rounded-full v-btn v-btn--contained v-btn--is-elevated v-btn--has-bg v-btn--rounded theme--light v-size--default elevation-1">
                    <span class="v-btn__content">
                        <i aria-hidden="true" class="v-icon notranslate mr-1 fas fa-unlock-alt theme--light" style="font-size: 14px;"></i>
                        {{ __('Email Password Reset Link') }}
                    </span>
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>