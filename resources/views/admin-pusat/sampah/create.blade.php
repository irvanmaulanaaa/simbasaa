<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Sampah') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
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
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Data Sampah</a>
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
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Whoops!</strong> Ada masalah dengan input Anda.
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin-pusat.sampah.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="nama_sampah" :value="__('Nama Sampah')" />
                                <x-text-input id="nama_sampah" class="block mt-1 w-full" type="text"
                                    name="nama_sampah" :value="old('nama_sampah')" required autofocus />
                                <x-input-error :messages="$errors->get('nama_sampah')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kode_sampah" :value="__('Kode Sampah')" />
                                <x-text-input id="kode_sampah" class="block mt-1 w-full" type="text"
                                    name="kode_sampah" :value="old('kode_sampah')" required />
                                <x-input-error :messages="$errors->get('kode_sampah')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kategori_id" :value="__('Kategori Sampah')" />
                                <select id="kategori_id" name="kategori_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
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

                            <div>
                                <x-input-label for="harga_anggota" :value="__('Harga Anggota')" />
                                <x-text-input id="harga_anggota" class="block mt-1 w-full" type="number"
                                    name="harga_anggota" :value="old('harga_anggota')" required />
                                <x-input-error :messages="$errors->get('harga_anggota')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="UOM" :value="__('Satuan (UOM)')" />
                                <select id="UOM" name="UOM"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                    required>
                                    <option value="kg" {{ old('UOM') == 'kg' ? 'selected' : '' }}>Kilogram (Kg)
                                    </option>
                                    <option value="pcs" {{ old('UOM') == 'pcs' ? 'selected' : '' }}>Satuan (Pcs)
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('UOM')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status_sampah" :value="__('Status Sampah')" />
                                <select id="status_sampah" name="status_sampah"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                    required>
                                    <option value="aktif" {{ old('status_sampah') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="tidak_aktif"
                                        {{ old('status_sampah') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status_sampah')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Data Sampah') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
