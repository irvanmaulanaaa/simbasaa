<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white shadow-sm rounded-lg mb-4">
            <div class="p-6 text-gray-900">
                <h3 class="text-2xl font-semibold">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
                <p class="mt-2 text-gray-600">Anda login sebagai Admin Pusat. Tugas Anda adalah mengelola data master
                    sampah dan jadwal penimbangan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Jenis Sampah</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSampah }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sampah Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sampahAktif }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
