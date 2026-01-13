<x-app-layout>
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

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 relative">

                    {{-- INIT ALPINE DATA --}}
                    <div x-data="{
                        submitting: false,
                        code: '{{ old('kode_sampah') }}',
                        isDuplicate: false,
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
                        }
                    }">

                        {{-- OVERLAY LOADING --}}
                        <div x-show="submitting"
                            class="absolute inset-0 bg-white bg-opacity-80 z-50 flex flex-col items-center justify-center rounded-lg"
                            style="display: none;">
                            <div
                                class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4">
                            </div>
                            <p class="text-green-700 font-bold text-lg animate-pulse">Menyimpan Data...</p>
                        </div>

                        <form action="{{ route('admin-pusat.sampah.store') }}" method="POST"
                            @submit="if(isDuplicate){ $event.preventDefault(); return; } submitting = true" novalidate>
                            @csrf

                            <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Identitas Sampah</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                                {{-- Nama Sampah --}}
                                <div>
                                    <x-input-label for="nama_sampah">
                                        {{ __('Nama Sampah') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <x-text-input id="nama_sampah" class="block mt-1 w-full" type="text"
                                        name="nama_sampah" :value="old('nama_sampah')" required autofocus
                                        placeholder="Contoh: Botol Plastik Bersih" />
                                    <x-input-error :messages="$errors->get('nama_sampah')" class="mt-2" />
                                </div>

                                {{-- Kategori --}}
                                <div>
                                    <x-input-label for="kategori_id">
                                        {{ __('Kategori Sampah') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <select id="kategori_id" name="kategori_id"
                                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm cursor-pointer"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}"
                                                {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                                </div>

                                {{-- Kode Sampah (DENGAN CEK DUPLIKAT) --}}
                                <div>
                                    <x-input-label for="kode_sampah">
                                        {{ __('Kode Sampah') }} <span class="text-red-500">*</span>
                                    </x-input-label>

                                    <x-text-input id="kode_sampah" class="block mt-1 w-full uppercase" type="text"
                                        name="kode_sampah" x-model="code" @input.debounce.500ms="checkCode()" required
                                        placeholder="Contoh: PL-001"
                                        x-bind:class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': isDuplicate }" />
                                    <p class="text-xs text-gray-500 mt-1">
                                        Kode tidak boleh sama dengan sampah lain.
                                    </p>
                                    {{-- Pesan Error Real-time --}}
                                    <p x-show="isDuplicate"
                                        class="text-sm text-red-600 mt-1 font-semibold animate-pulse"
                                        style="display: none;">
                                        Kode ini sudah digunakan!
                                    </p>

                                    <x-input-error :messages="$errors->get('kode_sampah')" class="mt-2" />
                                </div>

                                {{-- Kode BSB --}}
                                <div>
                                    <x-input-label for="kode_bsb">
                                        {{ __('Kode Sampah BSB') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <x-text-input id="kode_bsb" class="block mt-1 w-full uppercase" type="text"
                                        name="kode_bsb" :value="old('kode_bsb')" required placeholder="Contoh: K-01" />
                                    <p class="text-xs text-gray-500 mt-1">
                                        Wajib diisi sesuai data lama. Kode boleh sama dengan sampah lain.
                                    </p>
                                    <x-input-error :messages="$errors->get('kode_bsb')" class="mt-2" />
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 mt-8">Harga & Satuan</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Satuan UOM --}}
                                <div>
                                    <x-input-label for="UOM">
                                        {{ __('Satuan (UOM)') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <select id="UOM" name="UOM"
                                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm cursor-pointer"
                                        required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="kg" {{ old('UOM') == 'kg' ? 'selected' : '' }}>Kilogram (Kg)
                                        </option>
                                        <option value="pcs" {{ old('UOM') == 'pcs' ? 'selected' : '' }}>Satuan (Pcs)
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('UOM')" class="mt-2" />
                                </div>

                                {{-- Status Sampah --}}
                                <div>
                                    <x-input-label for="status_sampah">
                                        {{ __('Status Sampah') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <select id="status_sampah" name="status_sampah"
                                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm cursor-pointer"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif"
                                            {{ old('status_sampah') == 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="tidak_aktif"
                                            {{ old('status_sampah') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status_sampah')" class="mt-2" />
                                </div>

                                {{-- Harga Beli --}}
                                <div>
                                    <x-input-label for="harga_anggota">
                                        {{ __('Harga Anggota') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="harga_anggota" id="harga_anggota"
                                            class="block w-full rounded-md border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                            placeholder="0" value="{{ old('harga_anggota') }}" required
                                            min="0">
                                    </div>
                                    <x-input-error :messages="$errors->get('harga_anggota')" class="mt-2" />
                                </div>

                                {{-- Harga Jual --}}
                                <div>
                                    <x-input-label for="harga_bsb">
                                        {{ __('Harga BSB') }} <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="harga_bsb" id="harga_bsb"
                                            class="block w-full rounded-md border-gray-300 pl-10 focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                            placeholder="0" value="{{ old('harga_bsb') }}" required min="0">
                                    </div>
                                    <x-input-error :messages="$errors->get('harga_bsb')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-8 border-t pt-4">
                                <a href="{{ route('admin-pusat.sampah.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Batal
                                </a>

                                {{-- TOMBOL SIMPAN --}}
                                <button type="submit"
                                    class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    :class="{ 'opacity-50 cursor-not-allowed': submitting || isDuplicate }"
                                    :disabled="submitting || isDuplicate">
                                    <span x-text="submitting ? 'Menyimpan...' : 'Simpan Data Sampah'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
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

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
</x-app-layout>
