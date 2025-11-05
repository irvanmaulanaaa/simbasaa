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
                <h3 class="text-2xl font-semibold">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
                <p class="mt-2 text-gray-600">Anda login sebagai Admin Data. Anda memiliki wewenang untuk mengelola data
                    master lokasi, pengguna, dan konten edukasi.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Kecamatan</p>
                    <p class="text-2xl font-bold text-gray-900">N/A</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Desa</p>
                    <p class="text-2xl font-bold text-gray-900">N/A</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13.5M8.25 6.253V3.5A2.25 2.25 0 0110.5 1.253h3A2.25 2.25 0 0115.75 3.5v2.753m-7.5 0a4.5 4.5 0 000 8.5h.008c.09.004.179.006.27.006h6.944a4.5 4.5 0 000-8.5h-.008a4.5 4.5 0 00-.27-.006H8.25z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Konten</p>
                    <p class="text-2xl font-bold text-gray-900">N/A</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
