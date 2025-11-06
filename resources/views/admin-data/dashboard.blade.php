<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="text-2xl font-semibold">Selamat Datang, {{ Auth::user()->nama_lengkap }}</h3>
                <p class="mt-2 text-gray-600">Anda login sebagai Admin Data. Anda memiliki wewenang untuk mengelola data
                    master lokasi, pengguna, dan konten edukasi.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <x-heroicon-o-users class="h-6 w-6 text-green-700" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <x-heroicon-o-computer-desktop class="h-6 w-6 text-green-700" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Konten</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalKonten }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <x-heroicon-o-building-office-2 class="h-6 w-6 text-green-700" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Kecamatan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalKecamatan }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <x-heroicon-o-building-office class="h-6 w-6 text-green-700" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Desa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalDesa }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
