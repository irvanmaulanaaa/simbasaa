<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMBASA') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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

                    <a href="{{ route('dashboard') }}"
                        class="px-5 py-2.5 bg-green-600 text-white text-base font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                        Dashboard
                    </a>

                    @auth
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
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Ubah Sampah Menjadi <span
                            class="text-green-500">Rupiah</span></h1>
                    <p class="mt-4 text-lg text-gray-600">Selamatkan lingkungan sambil menambah pundi-pundi tabungan
                        Anda. Bergabunglah dengan sistem bank sampah digital kami.</p>
                    <div class="mt-8">
                        <a href="{{ route('login') }}"
                            class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg text-lg">Mulai
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
                <h2 class="text-3xl font-bold">Bagaimana Caranya?</h2>
                <p class="mt-2 text-gray-600">Hanya dengan 3 langkah mudah.</p>
                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    <div
                        class="bg-white p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5">
                            1</div>
                        <h3 class="text-lg font-medium">Pilah Sampah</h3>
                        <p class="mt-2 text-gray-500">Pisahkan sampah anorganik di rumah Anda.</p>
                    </div>
                    <div
                        class="bg-white p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5">
                            2</div>
                        <h3 class="text-lg font-medium">Setor ke Kami</h3>
                        <p class="mt-2 text-gray-500">Bawa ke lokasi kami untuk ditimbang.</p>
                    </div>
                    <div
                        class="bg-white p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5">
                            3</div>
                        <h3 class="text-lg font-medium">Cek Tabungan</h3>
                        <p class="mt-2 text-gray-500">Nilai sampah otomatis jadi saldo tabungan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="konten" class="py-20 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Konten Edukasi</h2>
                    <p class="mt-2 text-gray-600">Informasi terbaru seputar bank sampah.</p>
                </div>

                @if (isset($kontens) && $kontens->count() > 0)
                    <div class="grid gap-8 md:grid-cols-3">
                        @foreach ($kontens as $item)
                            <div
                                class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100 flex flex-col h-full hover:shadow-xl transition duration-300">

                                <div class="h-48 overflow-hidden bg-gray-200 relative">
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
                                            class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 bg-gray-100">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div
                                        class="absolute top-0 right-0 bg-green-600 text-white text-xs font-bold px-3 py-1 m-2 rounded">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col flex-grow">
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 hover:text-green-600 transition">
                                        <a
                                            href="{{ route('public.konten.show', $item->id_konten) }}">{{ $item->judul }}</a>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                                        {{ Str::limit(strip_tags($item->deskripsi ?? $item->isi), 100) }}
                                    </p>
                                    <a href="{{ route('public.konten.show', $item->id_konten) }}"
                                        class="inline-flex items-center text-green-600 font-semibold hover:text-green-800 mt-auto">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <p class="text-gray-500 italic">Belum ada konten berita saat ini.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <footer class="bg-green-500 border-t">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-white text-lg">&copy; {{ date('Y') }} SIMBASA. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
