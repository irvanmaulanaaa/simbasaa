<x-guest-layout>
    <div class="text-center">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logobaru.png') }}" alt="Logo Bank Sampah" class="h-16 w-auto">
            <span class="mx-4 text-gray-300 text-2xl font-light">|</span>
            <span class="text-2xl font-semibold text-gray-700">SIMBASA</span>
        </div>
        <div class="mt-6">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
            <p class="text-gray-500">Silakan masuk menggunakan akun Anda.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-8">
        @csrf

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3 rounded-lg text-base bg-green-600 hover:bg-green-700">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
