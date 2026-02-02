<x-guest-layout>

    @section('title', 'Login')

    <div class="text-center">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logosimbasa.png') }}" alt="Logo Bank Sampah" class="h-16 w-auto">
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

        <div class="mt-4">
            <div class="relative">
                <input id="username"
                    class="block w-full px-4 pt-5 pb-2.5 text-gray-900 bg-white rounded-lg border appearance-none focus:outline-none focus:ring-0 peer lowercase
            {{ $errors->has('username') ? 'border-red-500 text-red-900 focus:border-red-500' : 'border-gray-300 focus:border-blue-600' }}"
                    type="text" name="username" value="{{ old('username') }}" x-model="username"
                    @input="username = $event.target.value.toLowerCase().replace(/\s/g, '')" placeholder=" "
                    autocomplete="username" />

                <label for="username"
                    class="absolute text-base font-medium duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-4 pointer-events-none
            {{ $errors->has('username') ? 'text-red-600 peer-focus:text-red-600' : 'text-gray-800 peer-focus:text-green-600' }}">
                    {{ __('Username') }}
                </label>
            </div>
            <p x-show="errUsername" x-text="errUsername" class="text-sm text-red-600 mt-2 space-y-1"
                style="display: none;"></p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />

        </div>

        <div class="relative mt-4">
            <div class="relative">
                <x-text-input id="password"
                    class="block w-full px-4 pt-5 pb-2 text-gray-900 bg-white rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer pr-10"
                    ::type="show ? 'text' : 'password'" name="password" x-model="password" placeholder=" "
                    autocomplete="current-password" />

                <label for="password"
                    class="absolute text-base font-medium text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-4 pointer-events-none">
                    Password
                </label>

                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-green-600 focus:outline-none transition z-20">
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
