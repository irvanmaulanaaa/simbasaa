<x-app-layout>

    @section('title', 'Dashboard Ketua')

    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-8 space-y-8 min-h-screen flex flex-col">
        
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 to-emerald-800 shadow-xl text-white">
            <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white opacity-10 blur-3xl"></div>
            <div class="relative z-10 p-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h3 class="text-3xl font-bold">Selamat Datang, {{ Auth::user()->nama_lengkap }}! 👋</h3>
                    <p class="mt-2 text-green-50 text-lg opacity-90">
                        Selamat datang di Panel Ketua RW. Kelola sampah warga dengan mudah & transparan.
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
                    <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm font-semibold backdrop-blur-sm border border-white border-opacity-20">
                        {{ now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                        <h4 class="text-2xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($riwayatSetoran->sum('total_harga'), 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-500">
                    <span class="text-green-600 font-bold flex items-center mr-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Update Terkini
                    </span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Setoran</p>
                        <h4 class="text-2xl font-bold text-gray-900 mt-2">
                            {{ $riwayatSetoran->total() }} <span class="text-sm font-normal text-gray-500">Kali</span>
                        </h4>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-500">
                    <span class="text-blue-600 font-bold flex items-center mr-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Data Masuk
                    </span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Request Penarikan</p>
                        <h4 class="text-2xl font-bold text-gray-900 mt-2">
                            {{ $totalPenarikan }} <span class="text-sm font-normal text-gray-500">Permintaan</span>
                        </h4>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-500">
                    <span class="text-orange-600 font-bold flex items-center mr-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat & Pending
                    </span>
                </div>
            </div>

             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 flex flex-col justify-center gap-3">
                <p class="text-sm font-medium text-gray-500 mb-1">Aksi Cepat</p>
                <a href="{{ route('ketua.setoran.index') }}" class="flex items-center justify-between w-full px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium text-sm">
                    <span>Input Setoran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </a>
                <a href="{{ route('ketua.penarikan.index') }}" class="flex items-center justify-between w-full px-4 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium text-sm">
                    <span>Cek Penarikan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            Riwayat Setoran Terbaru
                        </h3>
                        <a href="{{ route('ketua.setoran.index') }}" class="text-sm font-medium text-green-600 hover:text-green-800 transition">
                            Lihat Semua
                        </a>
                    </div>
        
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-sm whitespace-nowrap">
                            <thead class="bg-gray-50 text-gray-500 uppercase font-semibold">
                                <tr>
                                    <th class="py-4 px-6 text-left w-10">No</th>
                                    <th class="py-4 px-6 text-left">Tanggal</th>
                                    <th class="py-4 px-6 text-left">Nama Warga</th>
                                    <th class="py-4 px-6 text-center">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 divide-y divide-gray-100">
                                @forelse ($riwayatSetoran as $setoran)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="py-4 px-6 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->translatedFormat('d M Y') }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <span class="font-medium">{{ $setoran->warga->nama_lengkap }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs border border-green-200">
                                            Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 p-3 rounded-full mb-3">
                                               <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <span>Belum ada riwayat setoran terbaru.</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full">
                    <div class="p-6 border-b border-gray-100 justify-between flex items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            Konten Terbaru
                        </h3>
                        <a href="{{ route('public.konten.index') }}" class="text-sm font-medium text-green-600 hover:text-green-800 transition">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="p-4 space-y-4">
                        @forelse ($kontenTerbaru ?? [] as $edukasi)
                            @if (is_object($edukasi))
                                <div class="flex gap-4 items-start p-3">
                                    <div class="w-16 h-16 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden relative shadow-sm group-hover:shadow-md transition">
                                        @php
                                            $mediaItem = $edukasi->media->first();
                                            $path = $mediaItem ? $mediaItem->gambar : null;
                                            $imageUrl = null;
                                            $isVideo = false;

                                            if ($path) {
                                                if (\Illuminate\Support\Str::contains($path, ['youtube.com', 'youtu.be'])) {
                                                    $isVideo = true;
                                                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $path, $match);
                                                    $videoId = $match[1] ?? null;
                                                    if ($videoId) {
                                                        $imageUrl = "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg";
                                                    }
                                                } elseif (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
                                                    $imageUrl = $path;
                                                } else {
                                                    $imageUrl = Storage::url($path);
                                                }
                                            }
                                        @endphp

                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-300" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            @if ($isVideo)
                                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 group-hover:bg-opacity-10 transition">
                                                    <div class="bg-white rounded-full p-1 shadow-sm">
                                                        <svg class="w-3 h-3 text-red-600 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="w-full h-full items-center justify-center text-gray-400 bg-gray-100 hidden">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-bold text-gray-900 truncate leading-tight mb-1" title="{{ $edukasi->judul ?? 'Tanpa Judul' }}">
                                            {{ $edukasi->judul ?? 'Tanpa Judul' }}
                                        </h5>
                                        <p class="text-xs text-gray-500 mb-2 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($edukasi->deskripsi ?? ($edukasi->konten ?? 'Tidak ada deskripsi'), 60) }}
                                        </p>
                                        <div class="flex items-center text-[10px] text-gray-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($edukasi->created_at ?? now())->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="text-center py-8 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <p class="text-sm">Belum ada konten edukasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan Maulana.</p>
    </footer>
</x-app-layout>
