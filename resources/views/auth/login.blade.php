<x-guest-layout>
    <div class="text-center">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logobaru.png') }}" alt="Logo Bank Sampah" class="h-16 w-auto">
            <span class="mx-4 text-gray-300 text-2xl font-light">|</span>
            <span class="text-2xl font-semibold text-gray-700">SIMBASA</span>
        </div>
        <div class="mt-6">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
            <p class="text-gray-500">Silahkan masuk menggunakan akun Anda.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-8" novalidate x-data="{
        username: '{{ old('username') }}',
        password: '',
        show: false,
        errUsername: '',
        errPassword: '',
        validateLogin() {
            this.errUsername = '';
            this.errPassword = '';
            let isValid = true;
    
            if (!this.username) {
                this.errUsername = 'Silahkan isi username terlebih dahulu.';
                isValid = false;
            }
    
            if (!this.password) {
                this.errPassword = 'Silahkan isi password terlebih dahulu.';
                isValid = false;
            }
    
            if (isValid) {
                this.$el.submit();
            }
        }
    }"
        @submit.prevent="validateLogin">

        @csrf

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" x-model="username"
                autofocus autocomplete="username" />
            <p x-show="errUsername" x-text="errUsername" class="text-sm text-red-600 mt-2 space-y-1"
                style="display: none;"></p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="font-semibold" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full rounded-lg pr-10" ::type="show ? 'text' : 'password'" name="password"
                    x-model="password" autocomplete="current-password" />
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-green-600 focus:outline-none transition">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>

            <p x-show="errPassword" x-text="errPassword" class="text-sm text-red-600 mt-2 space-y-1"
                style="display: none;"></p>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 font-bold hover:text-green-800 hover:underline"
                    href="{{ route('password.manual_reset') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button
                class="w-full justify-center py-3 rounded-lg text-base bg-green-600 hover:bg-green-700 transition duration-150 ease-in-out">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-500">
                Belum punya akun?
                <a href="https://wa.me/6285263849464?text=Halo%20Admin%20SIMBASA%2C%20saya%20ingin%20mendaftar%20akun%20baru%20di%20SIMBASA."
                    target="_blank" class="font-bold text-green-600 hover:text-green-800 hover:underline">
                    Hubungi Admin
                </a>
            </p>
        </div>

        <div class="mt-3 pt-4 border-t border-gray-100">
            <a href="{{ url('/') }}"
                class="flex items-center justify-center w-full py-3 rounded-lg text-base font-semibold text-slate-500 bg-slate-50 border border-slate-200 hover:bg-slate-100 hover:text-slate-700 transition duration-150 ease-in-out">
                Kembali ke Beranda
            </a>
        </div>
    </form>
</x-guest-layout>
