<x-app-layout>

    @section('title', 'Dashboard Admin Pusat')

    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-8">

        <div
            class="relative bg-gradient-to-br from-green-700 to-emerald-900 rounded-2xl p-8 text-white shadow-xl mb-8 overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-yellow-400 opacity-20 rounded-full blur-xl">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h3 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->nama_lengkap }}! 👋</h3>
                    <p class="text-green-100 text-lg max-w-2xl">
                        Selamat datang di Panel Admin Pusat <strong>SIMBASA</strong>.
                        Kelola data master sampah, jadwal, dan edukasi dengan mudah.
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div
                class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-300 group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Jenis Sampah</p>
                        <h4 class="text-3xl font-bold text-gray-800 mt-2 group-hover:text-blue-600 transition">
                            {{ $totalSampah ?? 0 }} <span class="text-sm font-normal text-gray-400">Jenis</span>
                        </h4>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ $sampahAktif ?? 0 }}</span> &nbsp;<span class="text-gray-500">Status
                        Aktif</span>
                </div>
            </div>

            <div
                class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-300 group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Jadwal</p>
                        <h4 class="text-3xl font-bold text-gray-800 mt-2 group-hover:text-purple-600 transition">
                            {{ $totalJadwal ?? 0 }} <span class="text-sm font-normal text-gray-400">Kegiatan</span>
                        </h4>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-100 transition">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span>Terjadwal bulan ini</span>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-6 shadow-md text-white flex flex-col justify-between hover:shadow-xl transition duration-300">
                <div>
                    <h5 class="font-bold text-lg mb-1">Kelola Jadwal</h5>
                    <p class="text-gray-400 text-sm">Lihat dan atur jadwal penimbangan.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin-pusat.jadwal.index') }}"
                        class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 hover:bg-green-500 rounded-lg text-sm font-semibold transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Lihat Semua Jadwal
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Jadwal Penimbangan Terbaru</h3>
                    <a href="{{ route('admin-pusat.jadwal.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 whitespace-nowrap">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Lokasi (Desa)</th>
                                <th class="px-6 py-3">RW</th>
                                <th class="px-6 py-3">Jam</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalTerbaru ?? [] as $jadwal)
                                @if (is_object($jadwal))
                                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($jadwal->tgl_jadwal ?? now())->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $jadwal->desa->nama_desa ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                RW {{ $jadwal->rw_penimbangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $jadwal->jam_penimbangan ?? '-' }} WIB
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php $tgl = \Carbon\Carbon::parse($jadwal->tgl_jadwal ?? now()); @endphp
                                            @if ($tgl->isPast() && !$tgl->isToday())
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Selesai</span>
                                            @elseif($tgl->isToday())
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><span
                                                        class="w-2 h-2 mr-1 bg-green-500 rounded-full animate-pulse"></span>Hari
                                                    Ini</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Akan
                                                    Datang</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-10 h-10 mb-2 text-gray-300" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p>Belum ada jadwal yang ditambahkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Konten Terbaru</h3>

                    <a href="{{ route('public.konten.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>

                </div>

                <div class="p-4 space-y-4">
                    @forelse ($kontenTerbaru ?? [] as $edukasi)
                        @if (is_object($edukasi))
                            <div
                                class="flex gap-4 items-start p-3 rounded-lg hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                <div
                                    class="w-16 h-16 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden relative shadow-sm group-hover:shadow-md transition">
                                    @php
                                        $mediaItem = $edukasi->media->first();
                                        $path = $mediaItem ? $mediaItem->gambar : null;

                                        $imageUrl = null;
                                        $isVideo = false;

                                        if ($path) {
                                            if (Str::contains($path, ['youtube.com', 'youtu.be'])) {
                                                $isVideo = true;
                                                preg_match(
                                                    '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                                                    $path,
                                                    $match,
                                                );
                                                $videoId = $match[1] ?? null;

                                                if ($videoId) {
                                                    $imageUrl = "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg";
                                                }
                                            } elseif (Str::startsWith($path, ['http://', 'https://'])) {
                                                $imageUrl = $path;
                                            } else {
                                                $imageUrl = Storage::url($path);
                                            }
                                        }
                                    @endphp

                                    @if ($imageUrl)
                                        <img src="{{ $imageUrl }}"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition duration-300"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                        @if ($isVideo)
                                            <div
                                                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 group-hover:bg-opacity-10 transition">
                                                <div class="bg-white rounded-full p-1 shadow-sm">
                                                    <svg class="w-3 h-3 text-red-600 ml-0.5" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif

                                        <div
                                            class="w-full h-full items-center justify-center text-gray-400 bg-gray-100 hidden">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h5 class="text-sm font-bold text-gray-900 truncate leading-tight mb-1"
                                        title="{{ $edukasi->judul ?? 'Tanpa Judul' }}">
                                        {{ $edukasi->judul ?? 'Tanpa Judul' }}
                                    </h5>
                                    <p class="text-xs text-gray-500 mb-2 line-clamp-2">
                                        {{ Str::limit($edukasi->deskripsi ?? ($edukasi->konten ?? 'Tidak ada deskripsi'), 60) }}
                                    </p>
                                    <div class="flex items-center text-[10px] text-gray-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($edukasi->created_at ?? now())->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            <p class="text-sm">Belum ada konten edukasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan Maulana.</p>
    </footer>
</x-app-layout>
