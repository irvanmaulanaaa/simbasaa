<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.jenis_sampah.update', $jenisSampah->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama" value="Nama Jenis Sampah" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $jenisSampah->nama)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="kategori_sampah_id" value="Kategori Sampah" />
                            <select name="kategori_sampah_id" id="kategori_sampah_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_sampah_id', $jenisSampah->kategori_sampah_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="harga_per_kg" value="Harga per Kg (Rp)" />
                            <x-text-input id="harga_per_kg" class="block mt-1 w-full" type="number" name="harga_per_kg" :value="old('harga_per_kg', $jenisSampah->harga_per_kg)" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>