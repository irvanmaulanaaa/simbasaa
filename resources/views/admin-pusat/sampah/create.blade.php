<x-app-layout>

    @section('title', 'Tambah Data Sampah')

    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Sampah') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="py-6 px-4 sm:px-0" x-data="{
        code: '{{ old('kode_sampah') }}',
        isDuplicate: false,
        isLoading: false,
        errors: {},
    
        checkCode() {
            if (this.code.length > 2) {
                fetch('{{ route('admin-pusat.sampah.check-code') }}?code=' + this.code)
                    .then(response => response.json())
                    .then(data => {
                        this.isDuplicate = data.exists;
                    });
            } else {
                this.isDuplicate = false;
            }
        },
    
        validateAndSubmit() {
            this.errors = {};
            let adaError = false;
    
            const check = (id, msg) => {
                const el = document.getElementById(id);
                if (!el || !el.value.trim()) {
                    this.errors[id] = msg;
                    adaError = true;
                }
            };
    
            const checkSelect = (id, msg) => {
                const el = document.getElementById(id);
                if (!el || !el.value) {
                    this.errors[id] = msg;
                    adaError = true;
                }
            };
    
            check('nama_sampah', 'Nama sampah wajib diisi.');
            check('deskripsi', 'Deskripsi sampah wajib diisi.');
            checkSelect('kategori_id', 'Kategori wajib dipilih.');
    
            if (!this.code) {
                this.errors['kode_sampah'] = 'Kode sampah wajib diisi.';
                adaError = true;
            } else if (this.isDuplicate) {
                adaError = true;
            }
    
            check('kode_bsb', 'Kode BSB wajib diisi.');
            checkSelect('UOM', 'Satuan wajib dipilih.');
            checkSelect('status_sampah', 'Status wajib dipilih.');
    
            const hrgAnggota = document.getElementById('harga_anggota').value;
            if (!hrgAnggota || hrgAnggota < 0) {
                this.errors['harga_anggota'] = 'Harga anggota wajib diisi & tidak boleh minus.';
                adaError = true;
            }
    
            const hrgBsb = document.getElementById('harga_bsb').value;
            if (!hrgBsb || hrgBsb < 0) {
                this.errors['harga_bsb'] = 'Harga BSB wajib diisi & tidak boleh minus.';
                adaError = true;
            }
    
            if (adaError) {
                const firstError = Object.keys(this.errors)[0];
                const el = document.getElementById(firstError);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    el.focus();
                }
                return;
            }
    
            this.isLoading = true;
            document.getElementById('sampahForm').submit();
        }
    }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-pusat.dashboard') }}"
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
                            <a href="{{ route('admin-pusat.sampah.index') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Data
                                Sampah</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">

                <div x-show="isLoading"
                    class="absolute inset-0 bg-white bg-opacity-80 z-50 flex flex-col items-center justify-center rounded-lg"
                    style="display: none;" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
                    <p class="text-green-700 font-bold text-lg animate-pulse">Loading...</p>
                </div>

                <div class="p-6 text-gray-900">

                    <form id="sampahForm" action="{{ route('admin-pusat.sampah.store') }}" method="POST"
                        @submit.prevent="validateAndSubmit" novalidate>
                        @csrf

                        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Identitas Sampah</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div>
                                <x-input-label for="nama_sampah">
                                    {{ __('Nama Sampah') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="nama_sampah" class="block mt-1 w-full" type="text"
                                    name="nama_sampah" :value="old('nama_sampah')" placeholder="Contoh: Botol Plastik Bersih" />

                                <p x-show="errors.nama_sampah" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.nama_sampah" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('nama_sampah')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kategori_id">
                                    {{ __('Kategori Sampah') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <select id="kategori_id" name="kategori_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm cursor-pointer">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori }}"
                                            {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <p x-show="errors.kategori_id" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.kategori_id" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="deskripsi">
                                    {{ __('Deskripsi') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <textarea id="deskripsi" name="deskripsi"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                    rows="3" placeholder="Jelaskan detail sampah ini.">{{ old('deskripsi') }}</textarea>

                                <p x-show="errors.deskripsi" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.deskripsi" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kode_sampah">
                                    {{ __('Kode Sampah') }} <span class="text-red-500">*</span>
                                </x-input-label>

                                <x-text-input id="kode_sampah" class="block mt-1 w-full" type="text"
                                    name="kode_sampah" x-model="code" @input.debounce.500ms="checkCode()"
                                    placeholder="Contoh: PL-001"
                                    x-bind:class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': isDuplicate }" />

                                <p class="text-xs text-gray-500 mt-1">Kode tidak boleh sama dengan sampah lain.</p>

                                <p x-show="isDuplicate" class="text-sm text-red-600 mt-1 font-semibold animate-pulse"
                                    style="display: none;">
                                    Kode ini sudah digunakan!
                                </p>
                                <p x-show="errors.kode_sampah" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.kode_sampah" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('kode_sampah')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kode_bsb">
                                    {{ __('Kode Sampah BSB') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="kode_bsb" class="block mt-1 w-full" type="text"
                                    name="kode_bsb" :value="old('kode_bsb')" placeholder="Contoh: K-01" />
                                <p class="text-xs text-gray-500 mt-1">Wajib diisi sesuai data lama.</p>

                                <p x-show="errors.kode_bsb" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.kode_bsb" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('kode_bsb')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 mt-8">Harga & Satuan</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="UOM">
                                    {{ __('Satuan (UOM)') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <select id="UOM" name="UOM"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm cursor-pointer">
                                    <option value="">Pilih Satuan</option>
                                    <option value="kg" {{ old('UOM') == 'kg' ? 'selected' : '' }}>Kilogram (Kg)
                                    </option>
                                    <option value="pcs" {{ old('UOM') == 'pcs' ? 'selected' : '' }}>Satuan (Pcs)
                                    </option>
                                </select>
                                <p x-show="errors.UOM" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.UOM" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('UOM')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status_sampah">
                                    {{ __('Status Sampah') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <select id="status_sampah" name="status_sampah"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm cursor-pointer">
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ old('status_sampah') == 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="tidak_aktif"
                                        {{ old('status_sampah') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                <p x-show="errors.status_sampah" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.status_sampah" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('status_sampah')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="harga_anggota">
                                    {{ __('Harga Anggota') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="harga_anggota" id="harga_anggota"
                                        class="block w-full rounded-md border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                        placeholder="0" value="{{ old('harga_anggota') }}" min="0">
                                </div>
                                <p x-show="errors.harga_anggota" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.harga_anggota" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('harga_anggota')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="harga_bsb">
                                    {{ __('Harga BSB') }} <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="harga_bsb" id="harga_bsb"
                                        class="block w-full rounded-md border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                        placeholder="0" value="{{ old('harga_bsb') }}" min="0">
                                </div>
                                <p x-show="errors.harga_bsb" class="text-red-500 text-xs mt-1 font-semibold"
                                    x-text="errors.harga_bsb" style="display: none;"></p>
                                <x-input-error :messages="$errors->get('harga_bsb')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-4">
                            <a href="{{ route('admin-pusat.sampah.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>

                            <button type="submit"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                :class="{ 'opacity-50 cursor-not-allowed': isLoading || isDuplicate }"
                                :disabled="isLoading || isDuplicate">
                                <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Data Sampah'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan!',
                    text: 'Terdapat kesalahan pada inputan Anda. Silakan periksa kembali kolom yang berwarna merah.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Oke'
                });
            @endif
        });
    </script>
</x-app-layout>
