<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsip Wawasan - SIMBASA</title>

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
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .pattern-bg {
            background-color: #f8fafc;
            background-image: radial-gradient(#22c55e 0.5px, transparent 0.5px), radial-gradient(#22c55e 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            background-repeat: repeat;
        }
    </style>
</head>

<body class="bg-gray-50 text-slate-600 antialiased selection:bg-green-100 selection:text-green-700">

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
                        class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-600 hover:text-green-600 hover:bg-green-50 transition duration-300">
                        Home
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="ml-2 px-6 py-2.5 bg-green-600 text-white text-sm font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="ml-2 px-6 py-2.5 border-2 border-green-600 text-green-600 text-sm font-bold rounded-full hover:bg-green-600 hover:text-white transition duration-300">
                            Masuk Akun
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
                class="block px-4 py-3 rounded-xl text-slate-600 font-medium hover:bg-slate-50">Home</a>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="block text-center px-4 py-3 bg-green-600 text-white rounded-xl font-bold shadow-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="block text-center px-4 py-3 border-2 border-green-600 text-green-600 rounded-xl font-bold">Masuk</a>
            @endauth
        </div>
    </nav>

    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 pattern-bg opacity-30"></div>
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-green-200/20 blur-[100px] rounded-full pointer-events-none">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 pt-16 pb-12 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-xs font-bold tracking-wider uppercase mb-4 animate-fade-in-up">
                Bank Sampah Digital
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

            <form action="{{ route('public.konten.index') }}" method="GET" class="max-w-5xl mx-auto relative z-10">
                <div class="flex flex-col md:flex-row gap-4">

                    <div
                        class="flex-grow p-2 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100">
                        <div class="relative group h-full">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="cari" value="{{ request('cari') }}"
                                class="block w-full h-full pl-12 pr-4 py-4 bg-slate-50 border-0 text-slate-900 rounded-xl focus:ring-2 focus:ring-green-500 placeholder:text-slate-400 font-medium transition-all hover:bg-slate-100 focus:bg-white"
                                placeholder="Cari topik menarik...">
                        </div>
                    </div>

                    <div
                        class="md:w-1/3 p-2 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100">

                        <select name="filter" onchange="this.form.submit()"
                            style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"
                            class="peer w-full py-3 pl-4 pr-10 rounded-full shadow-sm border-2 border-green-500 focus:ring-4 focus:ring-green-100 focus:border-green-600 text-gray-700 bg-white bg-none transition cursor-pointer">
                            <option value="terbaru" {{ request('filter') == 'terbaru' ? 'selected' : '' }}>Terbaru
                            </option>
                            <option value="terlama" {{ request('filter') == 'terlama' ? 'selected' : '' }}>Terlama
                            </option>
                            <option value="populer" {{ request('filter') == 'populer' ? 'selected' : '' }}>Populer
                            </option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-green-600 transition-transform duration-300 peer-focus:rotate-180 justify-content-center">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                    </div>

                    <button type="submit"
                        class="md:hidden w-full bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-200 mt-2">
                        Cari
                    </button>

                </div>
            </form>
        </div>

        <div class="absolute bottom-0 w-full">
            <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="w-full text-gray-50 transform translate-y-px">
                <path d="M0 48H1440V0C1440 0 1140 48 720 48C300 48 0 0 0 0V48Z" fill="currentColor" />
            </svg>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16 min-h-[600px]">
        @if ($kontens->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($kontens as $item)
                    <a href="{{ route('public.konten.show', $item->id_konten) }}"
                        class="group relative bg-white rounded-[24px] border border-gray-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 transition-all duration-500 flex flex-col h-full overflow-hidden">

                        <div class="h-64 bg-slate-50 relative overflow-hidden flex items-center justify-center p-4">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                            </div>

                            @php
                                $media = $item->media->first();
                                $path = $media
                                    ? ($media->gambar && filter_var($media->gambar, FILTER_VALIDATE_URL)
                                        ? $media->gambar
                                        : Illuminate\Support\Facades\Storage::url($media->gambar))
                                    : null;
                            @endphp

                            @if ($path)
                                <img src="{{ $path }}"
                                    class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-700 ease-in-out relative z-0">
                            @else
                                <div class="text-slate-300 flex flex-col items-center">
                                    <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">No Image</span>
                                </div>
                            @endif

                            <div class="absolute top-4 right-4 z-20">
                                <span
                                    class="bg-white/90 backdrop-blur-md text-slate-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm border border-white/50">
                                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="p-7 flex flex-col flex-grow relative">
                            <div
                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 to-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                            </div>

                            <h3
                                class="text-xl font-bold text-slate-800 group-hover:text-green-600 transition-colors duration-300 mb-3 leading-snug tracking-tight">
                                {{ $item->judul }}
                            </h3>

                            <p class="text-slate-500 text-sm line-clamp-3 mb-6 flex-grow leading-relaxed">
                                {{ Str::limit(strip_tags($item->deskripsi ?? $item->isi), 130) }}
                            </p>

                            <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center text-sm font-medium text-slate-400">
                                    <svg class="w-4 h-4 mr-1.5 text-red-400 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                    </svg>
                                    {{ $item->jumlah_like }} <span class="hidden sm:inline ml-1">Suka</span>
                                </div>

                                <span
                                    class="inline-flex items-center text-sm font-bold text-green-600 group-hover:translate-x-1 transition-transform duration-300">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </span>
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
                    kata
                    kunci lain atau reset filter.</p>
                <a href="{{ route('public.konten.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-white border-2 border-slate-200 rounded-full text-slate-700 font-bold hover:border-green-500 hover:text-green-600 transition-all duration-300">
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

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
