<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kecamatan') }}
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

                    <form action="{{ route('admin-data.kecamatan.store') }}" method="POST">
                        @csrf
                        
                        <div>
                            <x-input-label for="nama_kecamatan" :value="__('Nama Kecamatan')" />
                            <x-text-input id="nama_kecamatan" class="block mt-1 w-full" type="text" name="nama_kecamatan" :value="old('nama_kecamatan')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_kecamatan')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="kab_kota" :value="__('Kabupaten/Kota')" />
                            <x-text-input id="kab_kota" class="block mt-1 w-full" type="text" name="kab_kota" :value="old('kab_kota')" required />
                            <x-input-error :messages="$errors->get('kab_kota')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>