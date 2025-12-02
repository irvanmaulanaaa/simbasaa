<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori Sampah') }}
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
                            <a href="{{ route('admin-pusat.kategori-sampah.index') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Kategori
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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin-pusat.kategori-sampah.update', $kategoriSampah->id_kategori) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama_kategori" :value="__('Nama Kategori')" />
                            <x-text-input id="nama_kategori" class="block mt-1 w-full" type="text"
                                name="nama_kategori" :value="old('nama_kategori', $kategoriSampah->nama_kategori)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_kategori')" class="mt-2" />
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
