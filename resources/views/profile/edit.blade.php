<x-app-layout>
    @php
        $role = Auth::user()->role->nama_role;
        $sidebarView = '';
        $dashboardRoute = '#';

        if ($role == 'admin_data') {
            $sidebarView = 'admin-data.partials.sidebar';
            $dashboardRoute = route('admin-data.dashboard');
        } elseif ($role == 'admin_pusat') {
            $sidebarView = 'admin-pusat.partials.sidebar';
            $dashboardRoute = route('admin-pusat.dashboard');
        } elseif ($role == 'ketua') {
            $dashboardRoute = '#';
        } else {
            $dashboardRoute = '#';
        }
    @endphp

    <x-slot name="sidebar">
        @if (View::exists($sidebarView))
            @include($sidebarView)
        @endif
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ $dashboardRoute }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">
                            Home
                        </a>
                    </li>

                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('profile.show') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Profile</a>
                        </div>
                    </li>

                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Edit Profile</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Hapus Akun') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Harap unduh data apa pun yang ingin Anda simpan sebelum menghapus akun.') }}
                            </p>
                        </header>

                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Hapus Akun') }}</x-danger-button>

                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Apakah Anda yakin ingin menghapus akun?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
                                </p>

                                <div class="mt-6">
                                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                                    <x-text-input id="password" name="password" type="password"
                                        class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" />

                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Batal') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        {{ __('Hapus Akun') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
