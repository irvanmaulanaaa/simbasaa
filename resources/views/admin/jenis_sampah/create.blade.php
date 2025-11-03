<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sampah Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.jenis_sampah.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="nama">
                                <span>Nama Sampah</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="kategori_sampah_id">
                                <span>Kategori Sampah</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select name="kategori_sampah_id" id="kategori_sampah_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_sampah_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_sampah_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="harga_per_kg">
                                <span>Harga per Kg (Rp)</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="harga_per_kg" class="block mt-1 w-full" type="number" name="harga_per_kg" :value="old('harga_per_kg')" required />
                            <x-input-error :messages="$errors->get('harga_per_kg')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>