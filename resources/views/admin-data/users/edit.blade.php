<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-data.dashboard') }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">Home</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin-data.users.index') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Manajemen
                                Pengguna</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-6 text-gray-900">

                    <form id="editForm" action="{{ route('admin-data.users.update', $user->id_user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="nama_lengkap">
                                    Nama Lengkap 
                                </x-input-label>
                                <x-text-input id="nama_lengkap"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    type="text" name="nama_lengkap" :value="old('nama_lengkap', $user->nama_lengkap)" />
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="username">
                                    Username <span class="text-xs text-gray-500 font-normal ml-1">(Huruf kecil, tanpa spasi!)</span>
                                </x-input-label>
                                <x-text-input id="username"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    type="text" name="username" :value="old('username', $user->username)" />                                
                                @error('username')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="password">
                                    Password Baru <span class="text-xs text-gray-500 font-normal ml-1">(Opsional, Min. 8
                                        Karakter)</span>
                                </x-input-label>
                                <div class="relative mt-1">
                                    <x-text-input id="password"
                                        class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10"
                                        type="password" name="password" placeholder="Kosongkan jika tidak ingin ubah" />
                                    <button type="button" onclick="togglePassword('password', 'eye-icon-pass')"
                                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg id="eye-icon-pass" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="password_confirmation">
                                    Konfirmasi Password Baru
                                </x-input-label>
                                <div class="relative mt-1">
                                    <x-text-input id="password_confirmation"
                                        class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 pr-10"
                                        type="password" name="password_confirmation" placeholder="Kosongkan jika tidak ingin ubah" />
                                    <button type="button"
                                        onclick="togglePassword('password_confirmation', 'eye-icon-conf')"
                                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg id="eye-icon-conf" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="no_telepon">Nomor Telepon</x-input-label>
                                <x-text-input id="no_telepon"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    type="text" name="no_telepon" :value="old('no_telepon', $user->no_telepon)" />
                                @error('no_telepon')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="jalan">Nama Jalan</x-input-label>
                                <x-text-input id="jalan"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    type="text" name="jalan" :value="old('jalan', $user->jalan)" />
                                @error('jalan')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="kecamatan_id">Kecamatan</x-input-label>
                                <select id="kecamatan_id" name="kecamatan_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id_kecamatan }}"
                                            {{ old('kecamatan_id', $user->desa->kecamatan_id ?? '') == $kecamatan->id_kecamatan ? 'selected' : '' }}>
                                            {{ $kecamatan->nama_kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="desa_id">Desa </x-input-label>
                                <select id="desa_id" name="desa_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                    <option value="">Pilih Desa</option>
                                    @if (isset($desas))
                                        @foreach ($desas as $desa)
                                            <option value="{{ $desa->id_desa }}"
                                                {{ old('desa_id', $user->desa_id) == $desa->id_desa ? 'selected' : '' }}>
                                                {{ $desa->nama_desa }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('desa_id')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="rt">RT </x-input-label>
                                <x-text-input id="rt"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    type="text" name="rt" :value="old('rt', $user->rt)" />
                                @error('rt')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="rw">RW </x-input-label>
                                <x-text-input id="rw"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    type="text" name="rw" :value="old('rw', $user->rw)" />
                                @error('rw')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="role_id">Role </x-input-label>
                                <select id="role_id" name="role_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id_role }}"
                                            {{ old('role_id', $user->role_id) == $role->id_role ? 'selected' : '' }}>
                                            {{ $role->nama_role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="status">Status</x-input-label>
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                    <option value="aktif"
                                        {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif"
                                        {{ old('status', $user->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak
                                        Aktif</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin-data.users.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Batal</a>
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg transform hover:scale-105 transition duration-200">
                                Update Pengguna
                            </button>
                        </div>
                    </form>
                </div>

                <div id="loadingOverlay"
                    class="absolute inset-0 bg-white bg-opacity-80 z-50 hidden flex-col items-center justify-center rounded-lg">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
                    <p class="text-green-700 font-bold text-lg animate-pulse">Menyimpan Perubahan...</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const eyeOpen =
                `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            const eyeClosed =
                `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = eyeClosed;
            } else {
                input.type = "password";
                icon.innerHTML = eyeOpen;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editForm');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // 1. Loading saat Submit
            editForm.addEventListener('submit', function() {
                loadingOverlay.classList.remove('hidden');
                loadingOverlay.classList.add('flex');
            });

            // 2. ALERT SUKSES (Ceklis Hijau) -> Otomatis Pindah
            @if (session('success_update'))
                loadingOverlay.classList.add('hidden');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success_update') }}',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.href = "{{ route('admin-data.users.index') }}";
                });
            @endif

            // 3. ALERT ERROR/VALIDASI
            @if ($errors->any())
                loadingOverlay.classList.add('hidden');
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Mohon periksa inputan Anda (bertanda merah).',
                    confirmButtonColor: '#ca8a04'
                });
            @endif

            // 4. Logic Fetch Desa (Agar bisa ganti desa saat edit)
            const kecamatanSelect = document.getElementById('kecamatan_id');
            const desaSelect = document.getElementById('desa_id');

            // Kita simpan nilai lama untuk pre-select jika user gagal validasi
            const oldDesa = "{{ old('desa_id', $user->desa_id) }}";

            kecamatanSelect.addEventListener('change', function() {
                const kecamatanId = this.value;
                desaSelect.innerHTML = '<option value="">Memuat...</option>';
                desaSelect.disabled = true;

                if (kecamatanId) {
                    fetch(`{{ route('admin-data.users.get-desa') }}?kecamatan_id=${kecamatanId}`)
                        .then(response => response.json())
                        .then(data => {
                            desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                            data.forEach(desa => {
                                // Cek apakah ini desa yang sedang dipilih (baik dari database atau old input)
                                const isSelected = (oldDesa == desa.id_desa) ? 'selected' : '';
                                desaSelect.innerHTML +=
                                    `<option value="${desa.id_desa}" ${isSelected}>${desa.nama_desa}</option>`;
                            });
                            desaSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error(error);
                            desaSelect.innerHTML = '<option value="">Gagal memuat desa</option>';
                        });
                } else {
                    desaSelect.innerHTML = '<option value="">Pilih Kecamatan Dulu</option>';
                    desaSelect.disabled = true;
                }
            });
        });
    </script>
</x-app-layout>
