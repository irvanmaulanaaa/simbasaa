<x-app-layout>

    @section('title', 'Dashboard Admin Data')

    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col min-h-screen">
        <div class="p-6 lg:p-10 space-y-8 flex-grow">

            <div
                class="relative bg-gradient-to-r from-green-600 to-teal-500 rounded-2xl shadow-xl overflow-hidden text-white">
                <div class="absolute right-0 top-0 h-full w-1/2 bg-white opacity-10 transform skew-x-12 translate-x-20">
                </div>
                <div class="relative p-8 md:p-10 z-10">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h3 class="text-3xl font-bold">Halo, {{ Auth::user()->nama_lengkap }}! 👋</h3>
                            <p class="mt-2 text-green-100 text-lg max-w-xl">
                                Selamat datang di panel Admin Data. Pantau perkembangan konten, kelola wilayah, dan
                                pengguna dalam satu tampilan.
                            </p>
                            <div class="mt-4 flex flex-wrap gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Desa {{ Auth::user()->desa->nama_desa ?? '-' }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm">
                            RW {{ Auth::user()->rw }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm">
                            RT {{ Auth::user()->rt }}
                        </span>
                    </div>
                        </div>
                        <div class="mt-6 md:mt-0">
                            <span
                                class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm font-semibold backdrop-blur-sm border border-white border-opacity-20">
                                {{ now()->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                            <x-heroicon-o-users class="h-8 w-8 text-blue-600" />
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-400">
                        <span class="text-green-500 flex items-center font-semibold mr-1">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Aktif
                        </span>
                        <span>Terdaftar di sistem</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Konten</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKonten }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-xl group-hover:bg-purple-100 transition-colors">
                            <x-heroicon-o-computer-desktop class="h-8 w-8 text-purple-600" />
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-400">
                        <span class="text-purple-500 font-semibold mr-1">Edukasi</span>
                        <span>Tersedia untuk publik</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Kecamatan</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKecamatan }}</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-xl group-hover:bg-orange-100 transition-colors">
                            <x-heroicon-o-building-office-2 class="h-8 w-8 text-orange-600" />
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-400">
                        <span>Wilayah Kabupaten</span>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Desa</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalDesa }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-xl group-hover:bg-green-100 transition-colors">
                            <x-heroicon-o-building-office class="h-8 w-8 text-green-600" />
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-400">
                        <span>Tersebar di kecamatan</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h4 class="text-lg font-bold text-gray-800">Konten Terbaru</h4>
                        <a href="{{ route('admin-data.konten.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Judul Konten</th>
                                    <th class="px-6 py-4">Penulis</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Waktu Upload</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($recentKonten as $konten)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            {{ Str::limit($konten->judul, 20) }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $konten->user->nama_lengkap ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $status = strtolower($konten->status->nama_status ?? '');
                                                $color = $status == 'published' ? 'green' : 'yellow';
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-700">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-500">
                                            {{ $konten->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada konten
                                            data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-8">

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Statistik Konten</h4>
                        <div class="relative h-64 w-full">
                            <canvas id="kontenChart"></canvas>
                        </div>
                        <div class="mt-4 text-center text-sm text-gray-500">
                            Perbandingan konten Published vs Draft
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin-data.konten.create') }}"
                                class="flex flex-col items-center justify-center p-4 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition cursor-pointer border border-blue-100">
                                <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-sm font-semibold">Konten Baru</span>
                            </a>
                            <a href="{{ route('admin-data.desa.index') }}"
                                class="flex flex-col items-center justify-center p-4 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition cursor-pointer border border-green-100">
                                <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold">Cek Desa</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan Maulana.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('kontenChart').getContext('2d');

            const labels = @json($chartLabels);
            const data = @json($chartData);

            const backgroundColors = labels.map(label => {
                const l = label.toLowerCase();
                if (l === 'published' || l === 'aktif') {
                    return 'rgba(34, 197, 94, 0.8)'; 
                } else if (l === 'draft' || l === 'pending' || l === 'tidak aktif') {
                    return 'rgba(234, 179, 8, 0.8)'; 
                } else {
                    return 'rgba(59, 130, 246, 0.8)'; 
                }
            });

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Konten',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    cutout: '65%',
                }
            });
        });
    </script>
</x-app-layout>
