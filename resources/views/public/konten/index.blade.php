<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konten Edukasi - SIMBASA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-nav {
            background: rgba(246, 255, 243, 0.876);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .premium-bg {
            background-color: #fcfdfc;
            background-image: radial-gradient(#dcfce7 1px, transparent 1px);
            background-size: 32px 32px;
        }

        select::-ms-expand {
            display: none;
        }
    </style>
</head>

<body class="premium-bg text-slate-600 antialiased selection:bg-green-100 selection:text-green-700">

    <nav class="glass-nav border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-green-200 rounded-full opacity-0 group-hover:opacity-50 blur transition duration-300">
                        </div>
                        <img src="{{ asset('images/logobaru.png') }}"
                            class="relative h-10 w-auto transform transition duration-300 group-hover:rotate-6">
                    </div>
                    <span
                        class="font-extrabold text-2xl text-slate-800 tracking-tight group-hover:text-green-600 transition duration-300">SIMBASA</span>
                </a>

                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ url('/') }}"
                        class="px-5 py-2.5 rounded-full text-lg font-bold text-slate-600 hover:text-green-600 hover:bg-green-50 transition duration-300">
                        Home
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="ml-2 px-6 py-2.5 bg-green-600 text-white text-sm font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="ml-2 px-6 py-2.5 bg-green-600 text-white text-base font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Masuk
                        </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn"
                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none transition">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu"
            class="hidden md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-100 p-4 space-y-3 absolute w-full shadow-xl">
            <a href="{{ url('/') }}"
                class="block text-center px-4 py-3 border-2 border-green-600 text-green-600 rounded-xl font-bold">Home</a>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="block text-center px-4 py-3 bg-green-600 text-white rounded-xl font-bold shadow-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="block text-center px-4 py-3 border-2 bg-green-600 text-white rounded-xl font-bold">Masuk</a>
            @endauth
        </div>
    </nav>

    <div class="relative bg-white overflow-hidden shadow-sm">
        <div class="absolute inset-0 bg-gradient-to-b from-white via-transparent to-transparent z-10"></div>
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-green-200/20 blur-[100px] rounded-full pointer-events-none">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 pt-16 pb-12 text-center z-20">
            <span
                class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-xs font-bold tracking-wider uppercase mb-4 animate-fade-in-up">
                Konten Edukasi BY SIMBASA
            </span>
            <h1
                class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">
                Jelajahi <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">Wawasan
                    Hijau</span>
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Temukan artikel, berita, dan edukasi terbaru seputar pengelolaan lingkungan dan daur ulang sampah di
                sini.
            </p>

            <form action="{{ route('public.konten.index') }}" method="GET" class="max-w-5xl mx-auto relative z-30">
                <div class="flex flex-col md:flex-row gap-4">
                    <div
                        class="flex-grow p-2 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 transition focus-within:ring-4 focus-within:ring-green-100 focus-within:border-green-400">
                        <div class="relative group h-full">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="cari" value="{{ request('cari') }}"
                                class="block w-full h-full pl-12 pr-4 py-4 bg-transparent border-0 text-slate-900 placeholder:text-slate-400 font-medium focus:ring-0"
                                placeholder="Cari topik menarik...">
                        </div>
                    </div>

                    <div
                        class="md:w-1/3 p-2 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 transition focus-within:ring-4 focus-within:ring-green-100 focus-within:border-green-400">
                        <div class="relative h-full">

                            <select name="filter" onchange="this.form.submit()"
                                style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;"
                                class="peer block w-full h-full pl-5 pr-10 py-4 bg-transparent border-0 text-slate-700 font-semibold cursor-pointer focus:ring-0">
                                <option value="terbaru" {{ request('filter') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request('filter') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                <option value="populer" {{ request('filter') == 'populer' ? 'selected' : '' }}>Populer</option>
                            </select>

                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-green-600 transition-transform duration-300 peer-focus:rotate-180">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="md:hidden w-full bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-200 mt-2">Cari</button>
                </div>
            </form>
        </div>

        <div class="absolute bottom-0 w-full text-slate-50 opacity-50">
            <svg viewBox="0 0 1440 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="w-full h-12">
                <path d="M0 48H1440V0C1440 0 1140 48 720 48C300 48 0 0 0 0V48Z" />
            </svg>
        </div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-16 min-h-[600px]">
        <div
            class="absolute top-10 left-0 w-72 h-72 bg-purple-200/20 rounded-full blur-[80px] -z-10 pointer-events-none">
        </div>
        <div
            class="absolute bottom-10 right-0 w-72 h-72 bg-green-200/20 rounded-full blur-[80px] -z-10 pointer-events-none">
        </div>

        @if ($kontens->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($kontens as $item)
                    <a href="{{ route('public.konten.show', $item->id_konten) }}"
                        class="group relative bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-green-900/5 hover:-translate-y-2 transition-all duration-500 flex flex-col h-full overflow-hidden">

                        <div
                            class="h-64 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden flex items-center justify-center p-0">
                            <div
                                class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300 z-10">
                            </div>

                            @php
                                $media = $item->media->first();
                                $imagePath = null;
                                $isVideo = false;

                                if ($media) {
                                    if ($media->tipe == 'youtube' || (strpos($media->gambar, 'youtube.com') !== false || strpos($media->gambar, 'youtu.be') !== false)) {
                                        $isVideo = true;
                                        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $media->gambar, $matches);
                                        $videoId = $matches[1] ?? null;
                                        $imagePath = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : null;
                                    } else {
                                        $isUrl = filter_var($media->gambar, FILTER_VALIDATE_URL);
                                        $imagePath = $isUrl ? $media->gambar : Illuminate\Support\Facades\Storage::url($media->gambar);
                                    }
                                }
                            @endphp

                            @if ($imagePath)
                                <img src="{{ $imagePath }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out relative z-0">
                                
                                @if($isVideo)
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition-all duration-300 z-10">
                                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-300">
                                            <svg class="w-7 h-7 text-red-600 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-slate-300 flex flex-col items-center">
                                    <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium text-sm">Visual Tidak Tersedia</span>
                                </div>
                            @endif

                            <div class="absolute top-4 left-4 z-20">
                                <span
                                    class="bg-white/90 backdrop-blur text-slate-800 text-[10px] font-extrabold px-3 py-1 rounded-full border border-slate-200 uppercase tracking-wider shadow-sm">
                                    Konten
                                </span>
                            </div>
                        </div>

                        <div class="p-8 flex flex-col flex-grow relative">
                            <div
                                class="absolute top-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent group-hover:via-green-400 transition-colors duration-500">
                            </div>

                            <div class="mb-4">
                                <span class="text-green-600 text-xs font-bold flex items-center gap-1 mb-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                </span>
                                <h3
                                    class="text-xl font-bold text-slate-900 group-hover:text-green-600 transition-colors duration-300 leading-snug tracking-tight line-clamp-2">
                                    {{ $item->judul }}
                                </h3>
                            </div>

                            <p class="text-slate-500 text-sm line-clamp-3 mb-6 flex-grow leading-relaxed">
                                {{ Str::limit(strip_tags($item->deskripsi ?? $item->isi), 120) }}
                            </p>

                            <div class="flex items-center justify-between mt-auto pt-5 border-t border-slate-50">
                                <div class="flex items-center gap-2">
                                    @if($item->user && $item->user->profile_photo_path)
                                        <img src="{{ Storage::url($item->user->profile_photo_path) }}" class="w-8 h-8 rounded-full object-cover shadow-sm border border-slate-100">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-green-400 to-emerald-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                            {{ substr($item->user->nama_lengkap ?? 'A', 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="text-xs font-semibold text-slate-600">{{ $item->user->nama_lengkap ?? 'Admin' }}</span>
                                </div>

                                <div class="flex items-center gap-4 text-base font-bold text-slate-400">
                                    <div class="flex items-center gap-1 text-red-500 transition-colors">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                        </svg>
                                        {{ $item->jumlah_like }}
                                    </div>
                                    <span
                                        class="text-green-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform text-sm font-bold">
                                        Baca <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $kontens->links() }}
            </div>
        @else
            <div
                class="text-center py-24 bg-white rounded-[32px] border border-dashed border-slate-300 max-w-2xl mx-auto shadow-sm">
                <div class="bg-slate-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada konten ditemukan</h3>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">Kami tidak dapat menemukan apa yang Anda cari. Coba
                    kata kunci lain atau reset filter.</p>
                <a href="{{ route('public.konten.index') }}"
                    class="inline-flex items-center px-8 py-3 bg-white border-2 border-slate-200 rounded-full text-slate-700 font-bold hover:border-green-500 hover:text-green-600 transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Reset Filter
                </a>
            </div>
        @endif
    </div>

    <footer class="bg-green-50 border-t pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/logobaru.png') }}" class="h-12 w-auto mr-2" alt="Logo">
                        <span class="font-bold text-xl text-gray-800">SIMBASA</span>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-sm">
                        Aplikasi Bank Sampah Digital untuk Desa Sukapura. Mewujudkan lingkungan bersih, sehat, dan
                        mandiri secara ekonomi.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('public.konten.index') }}" class="hover:text-green-600">Konten</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-green-600">Masuk</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li>Desa Sukapura, Kab. Bandung, Jawa Barat, Indonesia</li>
                        <li>admin@simbasa.com</li>
                        <li>+62 1234 5678</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-8 text-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} SIMBASA. All rights reserved. Developed
                    with ❤️ by Irvan Maulana.</p>
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

    <div x-data="{ showBackToTop: false }" @scroll.window="showBackToTop = (window.pageYOffset > 300)">
        <button x-show="showBackToTop" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4"
            class="fixed bottom-8 right-8 z-50 bg-green-600 hover:bg-green-700 text-white p-3 rounded-full shadow-lg shadow-green-200 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300"
            style="display: none;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
            </svg>
        </button>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
