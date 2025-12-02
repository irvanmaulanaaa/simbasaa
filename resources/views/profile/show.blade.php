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
            {{ __('Profile Saya') }}
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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Profile</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Profil') }}
                        </h2>
                    </header>

                    <div class="mt-6 space-y-4">
                        <div>
                            <span class="block font-medium text-sm text-gray-700">Foto Profil</span>
                            <div class="mt-1">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="Foto Profil"
                                        class="h-20 w-20 rounded-full object-cover">
                                @else
                                    <div
                                        class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="block font-medium text-sm text-gray-700">Nama Lengkap</span>
                            <p class="mt-1 text-lg text-gray-900">{{ Auth::user()->nama_lengkap }}</p>
                        </div>
                        <div>
                            <span class="block font-medium text-sm text-gray-700">Username</span>
                            <p class="mt-1 text-lg text-gray-900">{{ Auth::user()->username }}</p>
                        </div>
                        <div>
                            <span class="block font-medium text-sm text-gray-700">Role</span>
                            <p class="mt-1 text-lg text-gray-900 capitalize">{{ Auth::user()->role->nama_role }}</p>
                        </div>

                        <div>
                            <span class="block font-medium text-sm text-gray-700">No. Telepon</span>
                            <p class="mt-1 text-lg text-gray-900">{{ Auth::user()->no_telepon ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block font-medium text-sm text-gray-700">Alamat Lengkap</span>
                            <p class="mt-1 text-lg text-gray-900">
                                {{ Auth::user()->jalan ?? 'Belum diatur' }},
                                RT {{ Auth::user()->rt ?? '-' }} / RW {{ Auth::user()->rw ?? '-' }},
                                {{ Auth::user()->desa->nama_desa ?? '-' }},
                                {{ Auth::user()->desa->kecamatan->nama_kecamatan ?? '-' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4 pt-4 mt-4">
                            <a href="{{ route('profile.edit') }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Edit Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar Akun') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
