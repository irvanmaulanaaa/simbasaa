<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Desa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin-data.desa.update', $desa->id_desa) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <div class="mt-4">
                            <x-input-label for="kecamatan_id" :value="__('Kecamatan')" />
                            <select name="kecamatan_id" id="kecamatan_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id_kecamatan }}" 
                                        @if($desa->kecamatan_id == $kecamatan->id_kecamatan) selected @endif>
                                        {{ $kecamatan->nama_kecamatan }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kecamatan_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="nama_desa" :value="__('Nama Desa')" />
                            <x-text-input id="nama_desa" class="block mt-1 w-full" type="text" name="nama_desa" :value="old('nama_desa', $desa->nama_desa)" required />
                            <x-input-error :messages="$errors->get('nama_desa')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>