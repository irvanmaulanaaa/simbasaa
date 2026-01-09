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
            $sidebarView = 'ketua.partials.sidebar';
            $dashboardRoute = route('ketua.dashboard');
        } else {
            $sidebarView = 'warga.partials.sidebar';
            $dashboardRoute = route('warga.dashboard');
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

    <div class="flex flex-col min-h-screen bg-gray-50/50" x-data="{
        isEditing: {{ $errors->any() ? 'true' : 'false' }},
    
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmPassword: false,
    
        selectedKecamatan: '{{ Auth::user()->desa->id_kecamatan ?? '' }}',
        selectedDesa: '{{ Auth::user()->desa_id ?? '' }}',
        desas: @js($allDesas),
        filteredDesas: [],
        init() { this.updateDesaList(); },
        updateDesaList() {
            this.filteredDesas = this.desas.filter(desa => desa.id_kecamatan == this.selectedKecamatan);
            if (!this.filteredDesas.some(d => d.id_desa == this.selectedDesa)) {
                if (this.selectedKecamatan != '{{ Auth::user()->desa->id_kecamatan ?? '' }}') { this.selectedDesa = ''; }
            }
        }
    }">

        <div class="flex-grow py-8 px-4 sm:px-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ $dashboardRoute }}"
                                class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600 transition">
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

                <div
                    class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                    <div class="h-40 bg-gradient-to-r from-emerald-600 to-red-700 relative overflow-hidden">
                        <div
                            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20 mix-blend-overlay">
                        </div>
                    </div>

                    <div class="relative px-6 pb-2 flex flex-col items-center -mt-20">
                        <div class="relative group">
                            <div
                                class="w-40 h-40 rounded-full border-[6px] border-white shadow-2xl overflow-hidden bg-white flex items-center justify-center relative z-10">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="Foto Profil"
                                        class="w-full h-full object-cover transition transform group-hover:scale-105 duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-green-600 flex items-center justify-center text-white text-6xl font-bold select-none">
                                        {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <form id="photoForm" method="POST" action="{{ route('profile.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="file" id="profile_photo" name="profile_photo" class="hidden"
                                    onchange="document.getElementById('photoForm').submit();">
                                <button type="button" onclick="document.getElementById('profile_photo').click();"
                                    class="absolute bottom-3 right-3 z-20 w-10 h-10 bg-white text-green-600 rounded-full shadow-lg border-2 border-gray-100 flex items-center justify-center hover:bg-green-600 hover:text-white hover:border-green-600 transition-all duration-300 transform hover:scale-110"
                                    title="Ganti Foto Profil">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 text-center">
                            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                                {{ Auth::user()->nama_lengkap }}</h1>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 mx-8 mt-6"></div>

                    <form method="post" action="{{ route('profile.update') }}" class="px-8 py-8 bg-white">
                        @csrf
                        @method('patch')

                        <div class="flex flex-row justify-between items-center mb-8">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Pribadi
                            </h3>
                            <div class="flex gap-2">
                                <button type="button" x-show="!isEditing" @click="isEditing = true"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Edit
                                </button>
                                <div x-show="isEditing" class="flex gap-2" style="display: none;">
                                    <button type="button" @click="isEditing = false"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 transition shadow-sm">Batal</button>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 transition shadow-sm">Simpan</button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div
                                class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-green-200 transition group">
                                <label
                                    class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Username</label>
                                <div x-show="!isEditing"
                                    class="flex items-center text-gray-900 font-semibold text-base">
                                    {{ Auth::user()->username }}</div>
                                <div x-show="isEditing" style="display: none;">
                                    <input type="text" name="username"
                                        value="{{ old('username', Auth::user()->username) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                    <x-input-error class="mt-1" :messages="$errors->get('username')" />
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-green-200 transition group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nama Lengkap</label>
                                <div x-show="!isEditing"
                                    class="flex items-center text-gray-900 font-semibold text-base">
                                    {{ Auth::user()->nama_lengkap }}</div>
                                <div x-show="isEditing" style="display: none;">
                                    <input type="text" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                    <x-input-error class="mt-1" :messages="$errors->get('nama_lengkap')" />
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-green-200 transition group">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Role</label>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium bg-gray-200 text-gray-800 cursor-not-allowed">{{ Auth::user()->role->nama_role }}</span>
                            </div>
                            <div
                                class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-green-200 transition group">
                                <label
                                    class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Status</label>
                                @if (Auth::user()->status == 'aktif')
                                    <span
                                        class="inline-flex items-center text-sm font-bold text-green-600 cursor-not-allowed"><span
                                            class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2 animate-pulse"></span>Aktif</span>
                                @else
                                    <span
                                        class="inline-flex items-center text-sm font-bold text-red-600 cursor-not-allowed"><span
                                            class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span>Tidak Aktif</span>
                                @endif
                            </div>
                            <div
                                class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-green-200 transition group lg:col-span-4">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">No.
                                    Telepon</label>
                                <div x-show="!isEditing"
                                    class="flex items-center text-gray-900 font-semibold text-base"><svg
                                        class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>{{ Auth::user()->no_telepon ?? '-' }}</div>
                                <div x-show="isEditing" style="display: none;">
                                    <input type="text" name="no_telp"
                                        value="{{ old('no_telp', Auth::user()->no_telepon) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                        placeholder="08xxxxxxxx">
                                    <x-input-error class="mt-1" :messages="$errors->get('no_telp')" />
                                </div>
                            </div>
                        </div>

                        <div
                            class="p-6 rounded-2xl bg-gradient-to-br from-white to-blue-50 border border-blue-100 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10"><svg class="w-24 h-24 text-blue-500"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg></div>
                            <div class="relative z-10">
                                <h4
                                    class="text-sm font-bold text-blue-800 uppercase tracking-wide mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Alamat Lengkap
                                </h4>
                                <div x-show="!isEditing">
                                    <p class="text-lg text-gray-800 font-medium mb-1">
                                        {{ Auth::user()->jalan ?? 'Nama jalan belum diatur' }}</p>
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <span
                                            class="px-3 py-1 bg-white border border-blue-200 text-blue-700 text-sm font-semibold rounded-md shadow-sm">RT.{{ Auth::user()->rt ?? '00' }}
                                            / RW.{{ Auth::user()->rw ?? '00' }}</span>
                                        <span
                                            class="px-3 py-1 bg-white border border-blue-200 text-blue-700 text-sm font-semibold rounded-md shadow-sm">Desa
                                            {{ Auth::user()->desa->nama_desa ?? '-' }}</span>
                                        <span
                                            class="px-3 py-1 bg-white border border-blue-200 text-blue-700 text-sm font-semibold rounded-md shadow-sm">Kec.
                                            {{ Auth::user()->desa->kecamatan->nama_kecamatan ?? '-' }}</span>
                                        <span
                                            class="px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded-md shadow-sm">{{ Auth::user()->desa->kecamatan->kab_kota ?? 'Kabupaten Bandung' }}</span>
                                    </div>
                                </div>
                                <div x-show="isEditing" style="display: none;" class="space-y-4 mt-2 max-w-2xl">
                                    <div><label class="block text-xs font-medium text-blue-700 mb-1">Nama
                                            Jalan</label><input type="text" name="jalan"
                                            value="{{ old('jalan', Auth::user()->jalan) }}"
                                            class="w-full rounded-md border-blue-200 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><label
                                                class="block text-xs font-medium text-blue-700 mb-1">RT</label><input
                                                type="text" name="rt"
                                                value="{{ old('rt', Auth::user()->rt) }}"
                                                class="w-full rounded-md border-blue-200 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                        <div><label
                                                class="block text-xs font-medium text-blue-700 mb-1">RW</label><input
                                                type="text" name="rw"
                                                value="{{ old('rw', Auth::user()->rw) }}"
                                                class="w-full rounded-md border-blue-200 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div><label
                                                class="block text-xs font-medium text-blue-700 mb-1">Kecamatan</label><select
                                                x-model="selectedKecamatan" @change="updateDesaList()"
                                                name="kecamatan_id"
                                                class="w-full rounded-md border-blue-200 focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white">
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id_kecamatan }}">
                                                        {{ $kecamatan->nama_kecamatan }}</option>
                                                @endforeach
                                            </select></div>
                                        <div><label
                                                class="block text-xs font-medium text-blue-700 mb-1">Desa</label><select
                                                x-model="selectedDesa" name="desa_id"
                                                class="w-full rounded-md border-blue-200 focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white"
                                                :disabled="!selectedKecamatan">
                                                <option value="">Pilih Desa (Pilih Kecamatan dulu)</option><template
                                                    x-for="desa in filteredDesas" :key="desa.id_desa">
                                                    <option :value="desa.id_desa" x-text="desa.nama_desa"
                                                        :selected="desa.id_desa == selectedDesa"></option>
                                                </template>
                                            </select></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
                        <p class="text-xs text-gray-400">Terdaftar pada
                            {{ Auth::user()->created_at->isoFormat('D MMMM Y') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/30 flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Keamanan Akun</h3>
                            <p class="text-sm text-gray-500">Perbarui kata sandi Anda secara berkala.</p>
                        </div>
                    </div>

                    <div class="p-8">
                        <form method="post" action="{{ route('password.update') }}"
                            class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password"
                                    class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                                <div class="relative">
                                    <input id="update_password_current_password" name="current_password"
                                        x-bind:type="showCurrentPassword ? 'text' : 'password'"
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm sm:text-sm pr-10"
                                        autocomplete="current-password">
                                    <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showCurrentPassword" class="h-5 w-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showCurrentPassword" style="display: none;" class="h-5 w-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="update_password_password"
                                    class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <div class="relative">
                                    <input id="update_password_password" name="password"
                                        x-bind:type="showNewPassword ? 'text' : 'password'"
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm sm:text-sm pr-10"
                                        autocomplete="new-password">
                                    <button type="button" @click="showNewPassword = !showNewPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showNewPassword" class="h-5 w-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showNewPassword" style="display: none;" class="h-5 w-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="update_password_password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password
                                    Baru</label>
                                <div class="relative">
                                    <input id="update_password_password_confirmation" name="password_confirmation"
                                        x-bind:type="showConfirmPassword ? 'text' : 'password'"
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm sm:text-sm pr-10"
                                        autocomplete="new-password">
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showConfirmPassword" class="h-5 w-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showConfirmPassword" style="display: none;" class="h-5 w-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="md:col-span-3 flex items-center justify-end gap-4 mt-2">
                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-green-600 font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Password Berhasil Diubah.
                                    </p>
                                @endif
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-gray-800 transition shadow-lg shadow-gray-300/50">
                                    Simpan Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
                Maulana. All rights reserved.</p>
        </footer>
    </div>
</x-app-layout>
