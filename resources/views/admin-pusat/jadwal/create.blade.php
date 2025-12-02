<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Buat Jadwal Penimbangan</h2>

                    <form action="{{ route('admin-pusat.jadwal.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_jadwal" :value="__('Tanggal Kegiatan')" />
                                <x-text-input id="tgl_jadwal" class="block mt-1 w-full" type="date" name="tgl_jadwal"
                                    :value="old('tgl_jadwal')" required />
                                <x-input-error :messages="$errors->get('tgl_jadwal')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jam_penimbangan" :value="__('Jam Mulai')" />
                                <x-text-input id="jam_penimbangan" class="block mt-1 w-full" type="time"
                                    name="jam_penimbangan" :value="old('jam_penimbangan')" required />
                                <x-input-error :messages="$errors->get('jam_penimbangan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="desa_id" :value="__('Lokasi Desa')" />
                                <select id="desa_id" name="desa_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">-- Pilih Desa --</option>
                                    @foreach ($desas as $desa)
                                        <option value="{{ $desa->id_desa }}">{{ $desa->nama_desa }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('desa_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rw_penimbangan" :value="__('Lokasi RW')" />
                                <x-text-input id="rw_penimbangan" class="block mt-1 w-full" type="text"
                                    name="rw_penimbangan" placeholder="Contoh: 005" :value="old('rw_penimbangan')" required />
                                <x-input-error :messages="$errors->get('rw_penimbangan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>{{ __('Simpan Jadwal') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
