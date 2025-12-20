<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMBASA') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .glass-nav {
            background: rgba(246, 255, 243, 0.876);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-700 bg-gray-50">

    <nav class="glass-nav border-b border-gray-100 sticky top-0 z-50 transition-all duration-300"
        x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-green-200 rounded-full opacity-0 group-hover:opacity-50 blur transition duration-300">
                        </div>
                        <img src="{{ asset('images/logobaru.png') }}"
                            class="relative h-12 w-auto transform transition duration-300 group-hover:rotate-6"
                            alt="SIMBASA">
                    </div>
                    <span
                        class="font-extrabold text-2xl text-slate-800 tracking-tight group-hover:text-green-600 transition duration-300">SIMBASA</span>
                </a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('public.konten.index') }}"
                        class="px-5 py-2.5 rounded-full text-lg font-bold text-slate-600 hover:text-green-600 hover:bg-green-50 transition duration-300">
                        Konten
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 bg-green-600 text-white text-base font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Dashboard
                        </a>

                        <div class="flex items-center pl-6 border-l border-slate-200">
                            <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 group" title="profile">
                                <div
                                    class="h-8 w-8 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold shadow-md ring-4 ring-white group-hover:scale-105 transition transform">
                                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="hidden sm:flex flex-col text-left">
                                    <span
                                        class="font-bold text-slate-800 text-sm leading-tight group-hover:text-green-600 transition">
                                        {{ Auth::user()->nama_lengkap }}
                                    </span>
                                    <span class="text-[8px] font-bold uppercase tracking-wider text-slate-400">
                                        {{ Auth::user()->role->nama_role }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="ml-2 px-6 py-2.5 bg-green-600 text-white text-base font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Masuk
                        </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none transition">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-100 p-4 space-y-3 absolute w-full shadow-xl z-40"
            style="display: none;">

            <a href="{{ route('public.konten.index') }}"
                class="block text-center px-4 py-3 border-2 border-green-600 text-green-600 rounded-xl font-bold text-lg">Konten</a>

            @auth
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-3 bg-green-600 rounded-xl border border-green-600 group hover:bg-green-100 transition">
                    <div class="flex items-center justify-center space-x-3">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-white group-hover:text-green-600 transition">
                                Dashboard
                            </span>
                        </div>
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="block text-center px-4 py-3 bg-green-600 text-white rounded-xl font-bold shadow-md hover:bg-green-700 transition text-lg">Masuk</a>
            @endauth
        </div>
    </nav>

    <main>
        <section class="bg-white">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">Ubah Sampah Menjadi
                        <span class="text-green-500">Rupiah</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">Selamatkan lingkungan sambil menambah pundi-pundi tabungan
                        Anda. Bergabunglah dengan sistem bank sampah digital kami.</p>
                    <div class="mt-8">
                        <a href="{{ route('login') }}"
                            class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg text-lg transition">Mulai
                            Menabung</a>
                    </div>
                </div>
                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('images/ilus.png') }}" alt="Ilustrasi" class="w-full max-w-md">
                </div>
            </div>
        </section>

        <section class="py-20 bg-green-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Bagaimana Caranya?</h2>
                <p class="mt-2 text-gray-600">Hanya dengan 3 langkah mudah.</p>
                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    <div
                        class="bg-white p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5 text-xl font-bold">
                            1</div>
                        <h3 class="text-lg font-medium text-gray-900">Pilah Sampah</h3>
                        <p class="mt-2 text-gray-500">Pisahkan sampah anorganik di rumah Anda.</p>
                    </div>
                    <div
                        class="bg-white p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5 text-xl font-bold">
                            2</div>
                        <h3 class="text-lg font-medium text-gray-900">Setor ke Kami</h3>
                        <p class="mt-2 text-gray-500">Bawa ke lokasi kami untuk ditimbang.</p>
                    </div>
                    <div
                        class="bg-white p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5 text-xl font-bold">
                            3</div>
                        <h3 class="text-lg font-medium text-gray-900">Cek Tabungan</h3>
                        <p class="mt-2 text-gray-500">Nilai sampah otomatis jadi saldo tabungan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-white relative z-20 -mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 md:p-12">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-100 text-center">

                        <div class="group">
                            <div
                                class="mb-3 inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <dt class="text-3xl font-extrabold text-gray-900 mb-1">250+</dt>
                            <dd class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pengguna</dd>
                        </div>

                        <div class="group">
                            <div
                                class="mb-3 inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <dt class="text-3xl font-extrabold text-gray-900 mb-1">1.2T</dt>
                            <dd class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sampah (Kg)</dd>
                        </div>

                        <div class="group">
                            <div
                                class="mb-3 inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <dt class="text-3xl font-extrabold text-gray-900 mb-1">Rp 50jt</dt>
                            <dd class="text-xs font-bold text-gray-400 uppercase tracking-widest">Dana Cair</dd>
                        </div>

                        <div class="group">
                            <div
                                class="mb-3 inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                    </path>
                                </svg>
                            </div>
                            <dt class="text-3xl font-extrabold text-gray-900 mb-1">50+</dt>
                            <dd class="text-xs font-bold text-gray-400 uppercase tracking-widest">Konten</dd>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section id="konten" class="py-24 bg-green-50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                    <div class="text-center md:text-left w-full md:w-auto">
                        <h2 class="text-3xl font-extrabold text-gray-900">Konten Edukasi</h2>
                        <p class="mt-2 text-gray-500">Wawasan terbaru untuk lingkungan yang lebih baik.</p>
                    </div>
                    <a href="{{ route('public.konten.index') }}"
                        class="hidden md:inline-flex items-center text-green-600 font-bold hover:text-green-800 transition text-base">
                        Lihat Semua Konten
                    </a>
                </div>

                @if (isset($kontens) && $kontens->count() > 0)
                    <div class="grid gap-8 md:grid-cols-3">
                        @foreach ($kontens as $item)
                            <a href="{{ route('public.konten.show', $item->id_konten) }}"
                                class="group flex flex-col h-full bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                                <div class="h-56 overflow-hidden bg-gray-50 relative">
                                    @php
                                        $media = $item->media->first();
                                        $imagePath = null;
                                        if ($media) {
                                            $isUrl = filter_var($media->gambar, FILTER_VALIDATE_URL);
                                            $imagePath = $isUrl
                                                ? $media->gambar
                                                : Illuminate\Support\Facades\Storage::url($media->gambar);
                                        }
                                    @endphp

                                    @if ($imagePath)
                                        <img src="{{ $imagePath }}" alt="{{ $item->judul }}"
                                            class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div
                                        class="absolute top-4 right-4 bg-white/90 backdrop-blur text-gray-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col flex-grow">
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors">
                                        {{ $item->judul }}
                                    </h3>
                                    <p class="text-gray-500 text-sm mb-6 line-clamp-3 flex-grow leading-relaxed">
                                        {{ Str::limit(strip_tags($item->deskripsi ?? $item->isi), 100) }}
                                    </p>

                                    <div
                                        class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
                                        <div
                                            class="flex items-center gap-1.5 text-lg font-bold text-red-600 transition-colors">
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                            </svg>
                                            <span>{{ $item->jumlah_like }}</span>
                                        </div>

                                        <span
                                            class="text-base font-medium text-green-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                            Baca Selengkapnya<svg class="w-6 h-6" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                        <p class="text-gray-500 font-medium">Belum ada konten berita saat ini.</p>
                    </div>
                @endif

                <div class="mt-10 text-center md:hidden text-base">
                    <a href="{{ route('public.konten.index') }}"
                        class="inline-block text-green-600 font-bold hover:text-green-800">
                        Lihat Semua Konten
                    </a>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Apa Saja yang Bisa Ditabung?</h2>
                <p class="text-gray-600 mb-12">Kami menerima berbagai jenis sampah anorganik yang bernilai ekonomis.
                </p>

                <div class="flex flex-wrap justify-center gap-6">
                    <div
                        class="bg-white px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                        <div class="text-4xl mb-3">🥤</div>
                        <h4 class="font-bold text-gray-800">Plastik</h4>
                        <span class="text-xs text-gray-500 mt-1">Botol, Gelas</span>
                    </div>
                    <div
                        class="bg-white px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                        <div class="text-4xl mb-3">📦</div>
                        <h4 class="font-bold text-gray-800">Kardus</h4>
                        <span class="text-xs text-gray-500 mt-1">Box Bekas</span>
                    </div>
                    <div
                        class="bg-white px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                        <div class="text-4xl mb-3">📰</div>
                        <h4 class="font-bold text-gray-800">Kertas</h4>
                        <span class="text-xs text-gray-500 mt-1">Koran, HVS</span>
                    </div>
                    <div
                        class="bg-white px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                        <div class="text-4xl mb-3">🔧</div>
                        <h4 class="font-bold text-gray-800">Logam</h4>
                        <span class="text-xs text-gray-500 mt-1">Besi, Kaleng</span>
                    </div>
                    <div
                        class="bg-white px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                        <div class="text-4xl mb-3">🧴</div>
                        <h4 class="font-bold text-gray-800">Botol Kaca</h4>
                        <span class="text-xs text-gray-500 mt-1">Kecap, Sirup</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="bg-gray-200 rounded-lg h-80 w-full flex items-center justify-center text-gray-400">
                            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Kegiatan Desa Sukapura" class="rounded-lg shadow-lg object-cover h-full w-full">
                        </div>
                    </div>
                    <div>
                        <span class="text-green-600 font-bold uppercase tracking-wide text-sm">Tentang SIMBASA</span>
                        <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-6">Solusi Digital untuk Pengelolaan Sampah
                            yang masih Manual</h2>
                        <div class="prose text-gray-600 space-y-4">
                            <p>
                                <strong>SIMBASA</strong> hadir sebagai respon terhadap tantangan pengelolaan sampah di
                                Desa Sukapura, Kabupaten Bandung. Website ini dibangun untuk mempermudah warga dalam
                                mencatat, memantau, dan menukar sampah menjadi nilai ekonomi.
                            </p>
                            <p>
                                Pengembangan sistem ini merupakan bagian dari <strong>Proyek Akhir</strong> yang
                                didukung penuh oleh kolaborasi strategis antara <strong>Mahasiswa, Layanan Kerjasama dan
                                    Magang serta CoE GreenTech Telkom University</strong>.
                            </p>
                            <p>
                                Kami percaya, dengan teknologi yang tepat, kebiasaan memilah sampah dapat menjadi budaya
                                baru yang menguntungkan secara finansial dan berdampak positif bagi lingkungan.
                            </p>
                        </div>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="https://telkomuniversity.ac.id/" target="_blank" rel="noopener noreferrer"
                                class="px-4 py-2 bg-green-50 text-gray-600 rounded-md text-sm font-semibold border border-gray-200 hover:bg-green-100 hover:text-green-700 transition duration-300">
                                Telkom University
                            </a>

                            <a href="https://greentech.center.telkomuniversity.ac.id/" target="_blank"
                                rel="noopener noreferrer"
                                class="px-4 py-2 bg-green-50 text-gray-600 rounded-md text-sm font-semibold border border-gray-200 hover:bg-green-100 hover:text-green-700 transition duration-300">
                                CoE GreenTech
                            </a>

                            <a href="https://magang-sas.telkomuniversity.ac.id/" target="_blank" rel="noopener noreferrer"
                                class="px-4 py-2 bg-green-50 text-gray-600 rounded-md text-sm font-semibold border border-gray-200 hover:bg-green-100 hover:text-green-700 transition duration-300">
                                Layanan Kerjasama dan Magang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-green-500">
            <div class="max-w-4xl mx-auto px-4 text-center text-white">
                <h2 class="text-3xl font-bold mb-6">Siap Menjadi Pahlawan Lingkungan?</h2>
                <p class="text-green-100 text-lg mb-10 max-w-2xl mx-auto">
                    Bergabunglah bersama ratusan warga Desa Sukapura lainnya. Langkah kecil Anda hari ini menciptakan
                    masa depan yang lebih hijau.
                </p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-white text-green-600 font-bold py-3 px-10 rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1">
                    Daftar Sekarang
                </a>
            </div>
        </section>

    </main>

    <footer class="bg-white border-t pt-12 pb-8">
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
                        <li><a href="#" class="hover:text-green-600">Beranda</a></li>
                        <li><a href="#konten" class="hover:text-green-600">Edukasi</a></li>
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
