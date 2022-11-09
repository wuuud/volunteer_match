<x-guest-layout>
    <x-jet-authentication-card>
        {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
        <h2 class="text-center text-xl font-bold font-xl mb-4 text-gtay-900">ログイン</h2>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            {{-- SNS認証用 授業テキストより --}}
            <br>
            <div class="flex justify-start">
                <a href="{{ url('auth/github') }}" class="block mr-5 bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-full">
                    <i class="fab fa-github"></i> GitHub
                </a>
                {{-- <a href="{{ url('auth/google') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
                    <i class="fab fa-google"></i> Google
                </a> --}}
            </div>


            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-sky-800 hover:font-bold"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4 bg-emerald-700 hover:bg-emerald-600">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
