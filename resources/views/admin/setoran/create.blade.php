<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setoran Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.setoran.store') }}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="user_id" value="Pilih Warga" />
                            <select name="user_id" id="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Nama Warga</option>
                                @foreach ($warga as $item)
                                    <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} (NIK: {{ $item->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="jenis_sampah_id" value="Pilih Jenis Sampah" />
                            <select name="jenis_sampah_id" id="jenis_sampah_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Jenis Sampah</option>
                                @foreach ($jenisSampah as $item)
                                    <option value="{{ $item->id }}" {{ old('jenis_sampah_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} (Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}/Kg)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_sampah_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                           <x-input-label for="berat" value="Berat (Kg)" />
                           <x-text-input id="berat" class="block mt-1 w-full" type="number" name="berat" :value="old('berat')" required step="0.01" />
                           <x-input-error :messages="$errors->get('berat')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Transaksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>