<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Home | {{ config('app.name', 'SIMBASA') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        .glass-nav {
            background: rgba(246, 255, 243, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
            will-change: opacity, transform;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .hamburger-line {
            transition: all 0.3s ease;
        }

        .hamburger-open .line-1 {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger-open .line-2 {
            opacity: 0;
        }

        .hamburger-open .line-3 {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-700 bg-gray-50" x-data="{ currentView: '{{ request('view', 'home') }}', mobileMenuOpen: false }" x-init="$watch('currentView', (value) => {
    const url = new URL(window.location);
    if (value === 'home') {
        url.searchParams.delete('view');
    } else {
        url.searchParams.set('view', value);
    }
    window.history.pushState({}, '', url);
})">

    <nav class="glass-nav border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center relative">

                <a href="#" @click.prevent="currentView = 'home'; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="flex items-center space-x-3 group z-20">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-green-200 rounded-full opacity-0 group-hover:opacity-50 blur transition duration-300">
                        </div>
                        <img src="{{ asset('images/logosimbasa.png') }}"
                            class="relative h-12 w-auto transform transition duration-300 group-hover:rotate-6"
                            alt="SIMBASA">
                    </div>
                    <span
                        class="font-extrabold text-2xl text-slate-800 tracking-tight group-hover:text-green-600 transition duration-300">SIMBASA</span>
                </a>

                <div
                    class="hidden md:flex absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 items-center space-x-8">

                    <button @click="currentView = 'home'; window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="text-lg font-bold transition focus:outline-none"
                        :class="currentView === 'home' ? 'text-green-600' : 'text-slate-600 hover:text-green-600'">
                        Home
                    </button>

                    <button @click="currentView = 'konten'; window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="text-lg font-bold transition focus:outline-none"
                        :class="currentView === 'konten' ? 'text-green-600' : 'text-slate-600 hover:text-green-600'">
                        Konten
                    </button>

                    <button @click="currentView = 'jenis-sampah'; window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="text-lg font-bold transition focus:outline-none"
                        :class="currentView === 'jenis-sampah' ? 'text-green-600' : 'text-slate-600 hover:text-green-600'">
                        Jenis Sampah
                    </button>

                    <button
                        @click="currentView = 'home'; setTimeout(() => document.getElementById('faq').scrollIntoView({behavior: 'smooth'}), 100)"
                        class="text-lg font-bold text-slate-600 hover:text-green-600 transition focus:outline-none">
                        FAQ
                    </button>
                </div>

                <div class="hidden md:flex items-center space-x-6 z-20">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 bg-green-600 text-white text-base font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Dashboard
                        </a>
                        <div class="flex items-center pl-6 border-l border-slate-200">
                            <a href="{{ route('profile.show') }}" class="flex items-center space-x-3 group"
                                title="profile">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                        alt="{{ Auth::user()->nama_lengkap }}"
                                        class="h-8 w-8 rounded-full object-cover shadow-md ring-4 ring-white group-hover:scale-105 transition transform">
                                @else
                                    <div
                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold shadow-md ring-4 ring-white group-hover:scale-105 transition transform">
                                        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                                <div class="hidden sm:flex flex-col text-left">
                                    <span
                                        class="font-bold text-sm text-gray-800 leading-tight group-hover:text-green-600 transition">{{ Auth::user()->nama_lengkap }}</span>
                                    <span class="text-xs text-gray-500 font-medium">{{ Auth::user()->username }}</span>
                                </div>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-6 py-2.5 bg-green-600 text-white text-base font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 hover:shadow-green-300 transform hover:-translate-y-0.5 transition duration-300">
                            Masuk
                        </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center z-20">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none transition relative w-10 h-10 flex items-center justify-center"
                        :class="{ 'hamburger-open': mobileMenuOpen }">
                        <div class="w-6 h-5 flex flex-col justify-between">
                            <span class="hamburger-line line-1 block h-0.5 w-full bg-current rounded-full"></span>
                            <span class="hamburger-line line-2 block h-0.5 w-full bg-current rounded-full"></span>
                            <span class="hamburger-line line-3 block h-0.5 w-full bg-current rounded-full"></span>
                        </div>
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

            <button @click="currentView = 'home'; mobileMenuOpen = false"
                class="block w-full text-center px-4 py-3 font-bold text-lg text-slate-600 hover:text-green-600 rounded-xl border border-green-600">Home</button>
            <button @click="currentView = 'konten'; mobileMenuOpen = false"
                class="block w-full text-center px-4 py-3 font-bold text-lg text-slate-600 hover:text-green-600 rounded-xl border border-green-600">Konten</button>
            <button @click="currentView = 'jenis-sampah'; mobileMenuOpen = false"
                class="block w-full text-center px-4 py-3 font-bold text-lg text-slate-600 hover:text-green-600 rounded-xl border border-green-600">Jenis
                Sampah</button>
            <button
                @click="currentView = 'home'; mobileMenuOpen = false; setTimeout(() => document.getElementById('faq').scrollIntoView({behavior: 'smooth'}), 100)"
                class="block w-full text-center px-4 py-3 font-bold text-lg text-slate-600 hover:text-green-600 rounded-xl border border-green-600">FAQ</button>

            @auth
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-3 bg-green-600 rounded-xl border border-green-600 group hover:bg-green-100 transition">
                    <div class="flex items-center justify-center space-x-3">
                        <span class="text-lg font-bold text-white group-hover:text-green-600 transition">Dashboard</span>
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="block text-center px-4 py-3 bg-green-600 text-white rounded-xl font-bold shadow-md hover:bg-green-700 transition text-lg">Masuk</a>
            @endauth
        </div>
    </nav>

    <main>

        <div x-show="currentView === 'home'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

            <section class="bg-white reveal">
                <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">Ubah Sampah Menjadi
                            <span class="text-green-500">Rupiah</span>
                        </h1>
                        <p class="mt-4 text-lg text-gray-600">Selamatkan lingkungan sambil menambah pundi-pundi
                            tabungan
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

            <section class="py-20 bg-white reveal">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-slate-900">
                        Bagaimana Cara Setor<span class="text-green-600"> Sampah?</span>
                    </h2>
                    <p class="mt-2 text-gray-600">Hanya dengan 3 langkah mudah.</p>
                    <div class="mt-12 grid gap-8 md:grid-cols-3">
                        <div
                            class="bg-green-50 p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                            <div
                                class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5 text-xl font-bold">
                                1</div>
                            <h3 class="text-lg font-medium text-gray-900">Pilah Sampah</h3>
                            <p class="mt-2 text-gray-500">Pisahkan sampah anorganik di rumah Anda.</p>
                        </div>
                        <div
                            class="bg-green-50 p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                            <div
                                class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5 text-xl font-bold">
                                2</div>
                            <h3 class="text-lg font-medium text-gray-900">Setor ke Kami</h3>
                            <p class="mt-2 text-gray-500">Bawa ke lokasi kami untuk ditimbang.</p>
                        </div>
                        <div
                            class="bg-green-50 p-8 rounded-lg shadow-lg text-center transform hover:-translate-y-2 transition duration-300">
                            <div
                                class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto mb-5 text-xl font-bold">
                                3</div>
                            <h3 class="text-lg font-medium text-gray-900">Cek Tabungan</h3>
                            <p class="mt-2 text-gray-500">Nilai sampah otomatis jadi saldo tabungan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-12 bg-white relative z-20 -mt-8 reveal">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div
                        class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 md:p-12">
                        <div class="text-center max-w-3xl mx-auto mb-16">
                            <h2 class="text-3xl font-extrabold text-slate-900">
                                Dampak Nyata <span class="text-green-600">SIMBASA</span>
                            </h2>
                            <p class="mt-4 text-lg text-gray-500">Transparansi data untuk membangun kepercayaan
                                masyarakat Desa Sukapura.</p>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-8  text-center">
                            <div class="group">
                                <div
                                    class="mb-3 inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-50 text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <dt class="text-3xl font-extrabold text-gray-900 mb-1">{{ $totalUser ?? '0' }}</dt>
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
                                <dt class="text-3xl font-extrabold text-gray-900 mb-1">
                                    {{ number_format(floor($totalSampah), 0, ',', '.') }} Kg+</dt>
                                <dd class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sampah Terkumpul
                                </dd>
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
                                <dt
                                    class="text-3xl font-extrabold text-gray-900 mb-2 flex justify-center items-baseline gap-1">
                                    <span class="text-2xl font-medium text-gray-400">Rp</span>
                                    {{ number_format($totalDanaCair, 0, ',', '.') }}
                                </dt>
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
                                <dt class="text-3xl font-extrabold text-gray-900 mb-1">{{ $totalKonten ?? '0' }}</dt>
                                <dd class="text-xs font-bold text-gray-400 uppercase tracking-widest">Konten</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-white reveal">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-green-600 mb-4">
                        Sampah <span class="text-slate-900">Apa Saja yang Bisa Disetor?</span>
                    </h2>
                    <p class="text-gray-600 mb-12">Kami menerima berbagai jenis sampah anorganik yang bernilai
                        ekonomis.</p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <div
                            class="bg-emerald-100 px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                            <div class="text-4xl mb-3">🥤</div>
                            <h4 class="font-bold text-gray-900">Plastik</h4>
                            <span class="text-xs text-gray-500 mt-1">Botol, Gelas</span>
                        </div>
                        <div
                            class="bg-emerald-100 px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                            <div class="text-4xl mb-3">📦</div>
                            <h4 class="font-bold text-gray-900">Kardus</h4>
                            <span class="text-xs text-gray-500 mt-1">Box Bekas</span>
                        </div>
                        <div
                            class="bg-emerald-100 px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                            <div class="text-4xl mb-3">📰</div>
                            <h4 class="font-bold text-gray-900">Kertas</h4>
                            <span class="text-xs text-gray-500 mt-1">Koran, HVS</span>
                        </div>
                        <div
                            class="bg-emerald-100 px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                            <div class="text-4xl mb-3">🔧</div>
                            <h4 class="font-bold text-gray-900">Logam</h4>
                            <span class="text-xs text-gray-500 mt-1">Besi, Kaleng</span>
                        </div>
                        <div
                            class="bg-emerald-100 px-8 py-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center w-40 hover:shadow-md transition">
                            <div class="text-4xl mb-3">🧴</div>
                            <h4 class="font-bold text-gray-900">Botol Kaca</h4>
                            <span class="text-xs text-gray-500 mt-1">Kecap, Sirup</span>
                        </div>
                    </div>

                    <div class="mt-12">
                        <button @click="currentView = 'jenis-sampah'; window.scrollTo({top: 0, behavior: 'smooth'})"
                            class="inline-flex items-center text-green-600 font-bold gap-2 text-lg">
                            Lihat Semua Jenis Sampah
                        </button>
                    </div>
                </div>
            </section>

            <section id="konten" class="py-24 bg-white relative reveal" x-data="{
                activeSlide: 0,
                totalSlides: {{ isset($kontens) ? $kontens->count() : 0 }},
                cardWidth: 340,
                scrollLeft() { this.$refs.slider.scrollBy({ left: -this.cardWidth, behavior: 'smooth' }); },
                scrollRight() { this.$refs.slider.scrollBy({ left: this.cardWidth, behavior: 'smooth' }); },
                scrollToSlide(index) { this.$refs.slider.scrollTo({ left: index * this.cardWidth, behavior: 'smooth' }); },
                updateActiveSlide() {
                    let scrollLeft = this.$refs.slider.scrollLeft;
                    this.activeSlide = Math.round(scrollLeft / this.cardWidth);
                }
            }">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                        <div class="text-center md:text-left w-full md:w-auto">
                            <h2 class="text-4xl font-extrabold text-green-600">
                                Konten <span class="text-slate-900">Edukasi</span>
                            </h2>
                            <p class="mt-2 text-gray-500">Wawasan terkini untuk lingkungan yang lebih baik.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <button @click="currentView = 'konten'; window.scrollTo({top: 0, behavior: 'smooth'})"
                                class="hidden md:inline-flex items-center text-green-600 font-bold hover:text-green-800 transition mr-4 text-lg">
                                Lihat Semua Konten
                            </button>
                        </div>
                    </div>

                    @if (isset($kontens) && $kontens->count() > 0)
                        <div class="relative group/slider">
                            <button @click="scrollLeft"
                                class="absolute left-0 top-1/2 -translate-y-1/2 -ml-5 z-20 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-600 p-3 rounded-full shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hidden md:block">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 19l-7-7 7-7">
                                    </path>
                                </svg>
                            </button>

                            <button @click="scrollRight"
                                class="absolute right-0 top-1/2 -translate-y-1/2 -mr-5 z-20 bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-600 p-3 rounded-full shadow-lg hover:bg-green-600 hover:text-white transition-all duration-300 opacity-0 group-hover/slider:opacity-100 hidden md:block">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>

                            <div x-ref="slider" @scroll.debounce.50ms="updateActiveSlide"
                                class="flex gap-6 overflow-x-auto no-scrollbar pb-8 snap-x snap-mandatory scroll-smooth px-2">
                                @foreach ($kontens as $index => $item)
                                    <div
                                        class="min-w-[320px] w-[320px] md:min-w-[370px] md:w-[370px] snap-center flex-shrink-0">
                                        <a href="{{ route('public.konten.show', $item->id_konten) }}"
                                            class="group flex flex-col h-full bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                            <div class="h-56 overflow-hidden bg-gray-50 relative">
                                                @php
                                                    $media = $item->media->first();
                                                    $imagePath = null;
                                                    $isVideo = false;
                                                    if ($media) {
                                                        if (
                                                            $media->tipe == 'youtube' ||
                                                            (strpos($media->gambar, 'youtube.com') !== false ||
                                                                strpos($media->gambar, 'youtu.be') !== false)
                                                        ) {
                                                            $isVideo = true;
                                                            preg_match(
                                                                "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/",
                                                                $media->gambar,
                                                                $matches,
                                                            );
                                                            $videoId = $matches[1] ?? null;
                                                            $imagePath = $videoId
                                                                ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
                                                                : null;
                                                        } else {
                                                            $isUrl = filter_var($media->gambar, FILTER_VALIDATE_URL);
                                                            $imagePath = $isUrl
                                                                ? $media->gambar
                                                                : Illuminate\Support\Facades\Storage::url(
                                                                    $media->gambar,
                                                                );
                                                        }
                                                    }
                                                @endphp
                                                @if ($imagePath)
                                                    <img src="{{ $imagePath }}" alt="{{ $item->judul }}"
                                                        class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                                    @if ($isVideo)
                                                        <div
                                                            class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition-all">
                                                            <div
                                                                class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                                                <svg class="w-6 h-6 text-red-600 ml-1"
                                                                    fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M8 5v14l11-7z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="flex items-center justify-center h-full text-gray-300">
                                                        <svg class="w-12 h-12" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
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
                                                    {{ $item->judul }}</h3>
                                                <p
                                                    class="text-gray-500 text-sm mb-6 line-clamp-3 flex-grow leading-relaxed">
                                                    {{ Str::limit(strip_tags($item->deskripsi ?? $item->isi), 100) }}
                                                </p>
                                                <div
                                                    class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
                                                    <div
                                                        class="flex items-center gap-1.5 text-lg font-bold text-red-500 transition-colors">
                                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                                            <path
                                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                                        </svg>
                                                        <span>{{ $item->jumlah_like }}</span>
                                                    </div>
                                                    <span
                                                        class="text-lg font-medium text-green-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform">Baca
                                                        Selengkapnya <svg class="w-6 h-6" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-center gap-2 mt-6">
                                <template x-for="i in totalSlides" :key="i">
                                    <button @click="scrollToSlide(i - 1)"
                                        class="h-2 rounded-full transition-all duration-300 ease-out"
                                        :class="activeSlide === (i - 1) ? 'w-8 bg-green-600' :
                                            'w-2 bg-gray-300 hover:bg-green-400'"
                                        :aria-label="'Go to slide ' + i"></button>
                                </template>
                            </div>

                        </div>
                    @else
                        <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                            <p class="text-gray-500 font-medium">Belum ada konten berita saat ini.</p>
                        </div>
                    @endif
                    <div class="mt-8 text-center md:hidden">
                        <button @click="currentView = 'konten'; window.scrollTo({top: 0, behavior: 'smooth'})"
                            class="inline-flex items-center text-green-600 font-bold hover:text-green-800 transition text-lg">Lihat
                            Semua Konten</button>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-white reveal">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <div>
                            <div
                                class="bg-gray-200 rounded-lg h-80 w-full flex items-center justify-center text-gray-400">
                                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                    alt="Kegiatan Desa Sukapura"
                                    class="rounded-lg shadow-lg object-cover h-full w-full">
                            </div>
                        </div>
                        <div>
                            <span class="text-green-600 font-bold uppercase tracking-wide text-base">Tentang
                                SIMBASA</span>
                            <h2 class="text-3xl font-bold text-green-600 mt-2 mb-6">Solusi Digital
                                <span class="text-slate-900"> untuk Pengelolaan</span>
                                <span class="text-green-600">Sampah</span>
                                <span class="text-slate-900"> yang masih Manual</span>
                            </h2>
                            <div class="prose text-gray-600 space-y-4">
                                <p><strong>SIMBASA</strong> hadir sebagai respon terhadap tantangan pengelolaan sampah
                                    di Desa Sukapura, Kabupaten Bandung.</p>
                                <p>Pengembangan sistem ini merupakan bagian dari <strong>Proyek Akhir</strong> yang
                                    didukung penuh oleh kolaborasi strategis antara <strong>Mahasiswa, Layanan Kerjasama
                                        dan Magang serta CoE GreenTech Telkom University</strong>.</p>
                                <p>Kami percaya, dengan teknologi yang tepat, kebiasaan memilah sampah dapat menjadi
                                    budaya baru yang menguntungkan secara finansial dan berdampak positif bagi
                                    lingkungan.</p>
                            </div>
                            <div class="mt-8 flex flex-wrap gap-4">
                                <a href="https://telkomuniversity.ac.id/" target="_blank"
                                    class="px-4 py-2 bg-green-50 text-gray-600 rounded-md text-sm font-semibold border border-gray-200 hover:bg-green-100 hover:text-green-700 transition duration-300">Telkom
                                    University</a>
                                <a href="https://greentech.center.telkomuniversity.ac.id/" target="_blank"
                                    class="px-4 py-2 bg-green-50 text-gray-600 rounded-md text-sm font-semibold border border-gray-200 hover:bg-green-100 hover:text-green-700 transition duration-300">CoE
                                    GreenTech</a>
                                <a href="https://magang-sas.telkomuniversity.ac.id/" target="_blank"
                                    class="px-4 py-2 bg-green-50 text-gray-600 rounded-md text-sm font-semibold border border-gray-200 hover:bg-green-100 hover:text-green-700 transition duration-300">Layanan
                                    Kerjasama dan Magang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="faq" class="py-20 bg-white reveal">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <span class="text-green-600 font-bold uppercase tracking-wide text-xl">FAQ</span>
                        <h2 class="text-3xl font-extrabold text-green-600 mt-2">Pertanyaan
                            <span class="text-slate-900"> yang Sering Ditanyakan</span>
                        </h2>
                        <p class="mt-4 text-gray-600">Jawaban cepat untuk pertanyaan umum Anda.</p>
                    </div>
                    <div class="space-y-4" x-data="{ activeAccordion: null }">
                        <div
                            class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm transition hover:shadow-md">
                            <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)"
                                class="w-full flex justify-between items-center p-5 text-left focus:outline-none">
                                <span class="font-bold text-gray-800 text-lg">Bagaimana cara mendaftar jadi
                                    nasabah?</span>
                                <span class="ml-6 flex-shrink-0 text-green-500"><svg
                                        class="w-6 h-6 transform transition-transform duration-200"
                                        :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg></span>
                            </button>
                            <div x-show="activeAccordion === 1" x-collapse
                                class="border-t border-gray-100 bg-gray-50/50">
                                <div class="p-5 text-gray-600 leading-relaxed">Silakan klik tombol "Masuk" lalu klik
                                    "Hubungi Admin" di bawah tombol MASUK pada halaman login.</div>
                            </div>
                        </div>
                        <div
                            class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm transition hover:shadow-md">
                            <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)"
                                class="w-full flex justify-between items-center p-5 text-left focus:outline-none">
                                <span class="font-bold text-gray-800 text-lg">Kapan jadwal penyetoran sampah?</span>
                                <span class="ml-6 flex-shrink-0 text-green-500"><svg
                                        class="w-6 h-6 transform transition-transform duration-200"
                                        :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg></span>
                            </button>
                            <div x-show="activeAccordion === 2" x-collapse
                                class="border-t border-gray-100 bg-gray-50/50">
                                <div class="p-5 text-gray-600 leading-relaxed">Jadwal penyetoran sampah dilakukan
                                    sesuai dengan jadwal penimbangan yang dapat dilihat melalui notifikasi
                                    masing-masing</div>
                            </div>
                        </div>
                        <div
                            class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm transition hover:shadow-md">
                            <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)"
                                class="w-full flex justify-between items-center p-5 text-left focus:outline-none">
                                <span class="font-bold text-gray-800 text-lg">Bagaimana cara mencairkan saldo?</span>
                                <span class="ml-6 flex-shrink-0 text-green-500"><svg
                                        class="w-6 h-6 transform transition-transform duration-200"
                                        :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg></span>
                            </button>
                            <div x-show="activeAccordion === 3" x-collapse
                                class="border-t border-gray-100 bg-gray-50/50">
                                <div class="p-5 text-gray-600 leading-relaxed">Login ke dashboard akun Anda, pilih menu
                                    "Tarik Saldo", masukkan nominal yang diinginkan.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-green-500 reveal">
                <div class="max-w-4xl mx-auto px-4 text-center text-white">
                    <h2 class="text-3xl font-bold mb-6">Siap Menjadi Pahlawan Lingkungan?</h2>
                    <p class="text-green-100 text-lg mb-10 max-w-2xl mx-auto">Bergabunglah bersama ratusan warga Desa
                        Sukapura lainnya.</p>
                    <a href="{{ route('login') }}"
                        class="inline-block bg-white text-green-600 font-bold py-3 px-10 rounded-lg shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1">Daftar
                        Sekarang</a>
                </div>
            </section>
        </div>

        <div x-show="currentView === 'jenis-sampah'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            style="display: none;">

            <section class="bg-gradient-to-br from-green-100/70 via-white to-green-100/50 py-16">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <span class="text-gray-800 font-bold tracking-wide uppercase text-sm mb-2 block">Informasi
                        Sampah</span>
                    <h1 class="text-4xl font-extrabold text-green-600">Jenis & Harga Sampah</h1>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Berikut adalah daftar lengkap sampah yang
                        kami terima beserta estimasi harganya.</p>
                </div>
            </section>

            <section class="py-12 bg-white min-h-screen" x-data="{
                search: '',
                selectedCategory: 'all',
                items: {{ $sampah->map(function ($item) {
                        return [
                            'id' => $item->id_sampah,
                            'nama' => $item->nama_sampah,
                            'harga' => number_format($item->harga_anggota, 0, ',', '.'),
                            'satuan' => $item->UOM,
                            'deskripsi' => $item->deskripsi ?? 'Sampah dalam keadaan bersih.',
                            'kategori' => $item->kategori ? $item->kategori->nama_kategori : 'Lainnya',
                        ];
                    })->toJson() }},
            
                get filteredItems() {
                    return this.items.filter(item => {
                        const matchesSearch = item.nama.toLowerCase().includes(this.search.toLowerCase());
                        const matchesCategory = this.selectedCategory === 'all' || item.kategori === this.selectedCategory;
                        return matchesSearch && matchesCategory;
                    });
                }
            }">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <div class="max-w-6xl mx-auto mb-12">
                        <div class="flex flex-col md:flex-row gap-4">

                            <div class="flex-grow relative">
                                <div
                                    class="relative group h-full bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 transition focus-within:ring-4 focus-within:ring-green-100 focus-within:border-green-400">

                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <svg class="h-6 w-6 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>

                                    <input type="text" name="search" id="search" x-model="search"
                                        placeholder="Cari jenis sampah..."
                                        class="block w-full h-full pl-14 pr-12 py-4 bg-transparent border-0 text-slate-900 placeholder:text-slate-400 font-medium focus:ring-0 rounded-[20px]">

                                    <button type="button" x-show="search.length > 0" @click="search = ''"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-red-500 transition cursor-pointer"
                                        style="display: none;">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="md:w-1/3 relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open" @click.away="open = false"
                                    class="relative w-full h-full p-4 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 text-left cursor-pointer focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all duration-300 group flex items-center justify-between">

                                    <span class="block truncate font-semibold text-slate-700">
                                        <span
                                            x-text="selectedCategory === 'all' ? 'Semua Kategori' : selectedCategory"></span>
                                    </span>

                                    <span class="flex items-center pointer-events-none text-green-600">
                                        <svg class="h-5 w-5 transition-transform duration-300"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </span>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                    class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden origin-top-right"
                                    style="display: none;">

                                    <div class="py-1 max-h-60 overflow-auto no-scrollbar">
                                        <div @click="selectedCategory = 'all'; open = false"
                                            class="cursor-pointer select-none relative py-3 pl-4 pr-9 hover:bg-green-50 transition duration-200 group border-b border-gray-50">
                                            <span class="text-sm font-medium text-gray-700 group-hover:text-green-700"
                                                :class="{ 'font-bold text-green-700': selectedCategory === 'all' }">
                                                Semua Kategori
                                            </span>
                                            <span x-show="selectedCategory === 'all'"
                                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-green-600">
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>

                                        @foreach ($kategoriSampah as $kat)
                                            <div @click="selectedCategory = '{{ $kat->nama_kategori }}'; open = false"
                                                class="cursor-pointer select-none relative py-3 pl-4 pr-9 hover:bg-green-50 transition duration-200 group border-b border-gray-50">
                                                <span
                                                    class="text-sm font-medium text-gray-700 group-hover:text-green-700"
                                                    :class="{
                                                        'font-bold text-green-700': selectedCategory ===
                                                            '{{ $kat->nama_kategori }}'
                                                    }">
                                                    {{ $kat->nama_kategori }}
                                                </span>
                                                <span x-show="selectedCategory === '{{ $kat->nama_kategori }}'"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-green-600">
                                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center md:text-left ml-2 text-sm text-slate-400 font-medium">
                            Menampilkan <span x-text="filteredItems.length" class="text-green-600 font-bold"></span>
                            jenis sampah
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 justify-center">
                        <template x-for="item in filteredItems" :key="item.id">
                            <div
                                class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 flex flex-col items-center hover:shadow-xl hover:shadow-green-900/5 hover:-translate-y-1 transition-all duration-300 group relative">

                                <span
                                    class="absolute top-4 right-4 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wide rounded-full bg-green-50 text-green-600 border border-green-100"
                                    x-text="item.kategori"></span>

                                <div
                                    class="text-6xl mb-6 mt-4 group-hover:scale-110 transition duration-300 drop-shadow-sm">
                                    <span x-show="item.nama.toLowerCase().includes('plastik')">🥤</span>
                                    <span
                                        x-show="item.nama.toLowerCase().includes('kertas') || item.nama.toLowerCase().includes('koran')">📰</span>
                                    <span
                                        x-show="item.nama.toLowerCase().includes('kardus') || item.nama.toLowerCase().includes('box')">📦</span>
                                    <span
                                        x-show="item.nama.toLowerCase().includes('besi') || item.nama.toLowerCase().includes('kaleng')">🔧</span>
                                    <span
                                        x-show="item.nama.toLowerCase().includes('botol') || item.nama.toLowerCase().includes('kaca')">🧴</span>
                                    <span
                                        x-show="!item.nama.toLowerCase().match(/plastik|kertas|koran|kardus|box|besi|kaleng|botol|kaca/)">♻️</span>
                                </div>

                                <h4 class="font-bold text-lg text-gray-800 text-center leading-snug"
                                    x-text="item.nama">
                                </h4>

                                <div class="mt-3 mb-2 flex items-baseline gap-1">
                                    <span class="text-sm font-bold text-gray-400">Rp</span>
                                    <span class="text-2xl font-extrabold text-green-600 tracking-tight"
                                        x-text="item.harga"></span>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">/<span
                                            x-text="item.satuan"></span></span>
                                </div>

                                <p class="text-xs text-gray-400 line-clamp-2 text-center leading-relaxed px-2"
                                    x-text="item.deskripsi"></p>
                            </div>
                        </template>

                        <div x-show="filteredItems.length === 0" class="col-span-full py-20 text-center">
                            <div
                                class="bg-gray-50 rounded-full h-24 w-24 flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ditemukan</h3>
                            <p class="text-gray-500 text-sm">Coba cari dengan kata kunci lain.</p>
                            <button @click="search = ''; selectedCategory = 'all'"
                                class="mt-4 text-sm font-bold text-green-600 hover:text-green-700 hover:underline">Reset
                                Pencarian</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div x-show="currentView === 'konten'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            style="display: none;" class="font-jakarta premium-bg">

            <div class="relative bg-white/0 overflow-visible z-40">
                <div
                    class="absolute inset-0 bg-gradient-to-b from-white via-transparent to-transparent z-10 pointer-events-none">
                </div>
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-green-100/20 blur-[100px] rounded-full pointer-events-none">
                </div>

                <div class="relative max-w-7xl mx-auto px-4 pt-16 pb-12 text-center z-20">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-700 text-xs font-bold tracking-wider uppercase mb-4 animate-fade-in-up">Konten
                        Edukasi BY SIMBASA</span>
                    <h1
                        class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">
                        Jelajahi <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">Wawasan
                            Hijau</span>
                    </h1>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                        Temukan artikel, berita, dan edukasi terbaru seputar pengelolaan lingkungan dan daur ulang
                        sampah di sini.
                    </p>
                </div>
            </div>

            <section class="relative max-w-7xl mx-auto px-4 pb-16 min-h-[600px] z-0" x-data="{
                searchKonten: '',
                selectedKategoriKonten: 'all',
                selectedSort: 'terbaru',
            
                kontenItems: {{ $kontens->map(function ($item) {
                        $media = $item->media->first();
                        $imagePath = null;
                        $isVideo = false;
                        if ($media) {
                            if (
                                $media->tipe == 'youtube' ||
                                (strpos($media->gambar, 'youtube.com') !== false || strpos($media->gambar, 'youtu.be') !== false)
                            ) {
                                $isVideo = true;
                                preg_match(
                                    '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/\s]{11})/',
                                    $media->gambar,
                                    $matches,
                                );
                                $imagePath = isset($matches[1]) ? 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg' : null;
                            } else {
                                $imagePath = filter_var($media->gambar, FILTER_VALIDATE_URL)
                                    ? $media->gambar
                                    : Illuminate\Support\Facades\Storage::url($media->gambar);
                            }
                        }
                        return [
                            'id' => $item->id_konten,
                            'judul' => $item->judul,
                            'deskripsi' => Str::limit(strip_tags($item->deskripsi ?? $item->isi), 100),
                            'kategori' => $item->kategoriKonten->nama_kategori ?? 'Umum',
                            'tanggal' => \Carbon\Carbon::parse($item->created_at)->format('d M Y'),
                            'penulis' => $item->user->nama_lengkap ?? ($item->user->name ?? 'Admin'),
                            'foto_penulis' =>
                                $item->user && $item->user->profile_photo_path ? Storage::url($item->user->profile_photo_path) : null,
                            'inisial_penulis' => substr($item->user->nama_lengkap ?? ($item->user->name ?? 'A'), 0, 1),
                            'likes' => $item->jumlah_like ?? 0,
                            'image' => $imagePath,
                            'isVideo' => $isVideo,
                            'url' => route('public.konten.show', $item->id_konten),
                        ];
                    })->toJson() }},
            
                get filteredKonten() {
                    let result = this.kontenItems.filter(item => {
                        const matchesSearch = item.judul.toLowerCase().includes(this.searchKonten.toLowerCase());
                        const matchesCategory = this.selectedKategoriKonten === 'all' || item.kategori === this.selectedKategoriKonten;
                        return matchesSearch && matchesCategory;
                    });
            
                    if (this.selectedSort === 'terbaru') {
                        return result.sort((a, b) => b.id - a.id);
                    } else if (this.selectedSort === 'terlama') {
                        return result.sort((a, b) => a.id - b.id);
                    } else if (this.selectedSort === 'populer') {
                        return result.sort((a, b) => b.likes - a.likes);
                    }
            
                    return result;
                }
            }">

                <div class="max-w-6xl mx-auto mb-12 relative z-30">
                    <div class="flex flex-col md:flex-row gap-4">

                        <div class="flex-grow relative">
                            <div
                                class="relative group h-full bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 transition focus-within:ring-4 focus-within:ring-green-100 focus-within:border-green-400">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" x-model="searchKonten" placeholder="Cari topik menarik..."
                                    class="block w-full h-full pl-14 pr-12 py-4 bg-transparent border-0 text-slate-900 placeholder:text-slate-400 font-medium focus:ring-0 rounded-[20px]">
                                <button type="button" x-show="searchKonten.length > 0" @click="searchKonten = ''"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-red-500 transition cursor-pointer"
                                    style="display: none;">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="md:w-1/4 relative" x-data="{ open: false }">
                            <button type="button" @click="open = !open" @click.away="open = false"
                                class="relative w-full h-full p-4 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 text-left flex items-center justify-between focus:outline-none transition-all duration-300">
                                <span class="block truncate font-semibold text-slate-700"
                                    x-text="selectedKategoriKonten === 'all' ? 'Semua Kategori' : selectedKategoriKonten"></span>
                                <svg class="h-5 w-5 text-green-600 transition-transform"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-transition
                                class="absolute z-[60] w-full mt-2 bg-white rounded-xl shadow-2xl overflow-hidden"
                                style="display: none;">
                                <div class="py-1 max-h-60 overflow-auto no-scrollbar">
                                    <div @click="selectedKategoriKonten = 'all'; open = false"
                                        class="cursor-pointer py-3 pl-4 hover:bg-green-50 text-sm font-medium text-gray-700 transition duration-200">
                                        Semua Kategori</div>
                                    @foreach ($kategoriKonten as $kat)
                                        <div @click="selectedKategoriKonten = '{{ $kat->nama_kategori }}'; open = false"
                                            class="cursor-pointer py-3 pl-4 hover:bg-green-50 text-sm font-medium text-gray-700 transition duration-200">
                                            {{ $kat->nama_kategori }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="md:w-1/4 relative" x-data="{ open: false }">
                            <button type="button" @click="open = !open" @click.away="open = false"
                                class="relative w-full h-full p-4 bg-white rounded-[20px] shadow-xl shadow-slate-200/60 border border-slate-100 text-left flex items-center justify-between focus:outline-none transition-all duration-300">
                                <span class="block truncate font-semibold text-slate-700"
                                    x-text="selectedSort === 'terbaru' ? 'Terbaru' : (selectedSort === 'terlama' ? 'Terlama' : 'Populer')"></span>
                                <svg class="h-5 w-5 text-green-600 transition-transform"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-transition
                                class="absolute z-[60] w-full mt-2 bg-white rounded-xl shadow-2xl overflow-hidden"
                                style="display: none;">
                                <div class="py-1">
                                    <div @click="selectedSort = 'terbaru'; open = false"
                                        class="cursor-pointer py-3 pl-4 hover:bg-green-50 text-sm font-medium text-gray-700 transition duration-200">
                                        Terbaru</div>
                                    <div @click="selectedSort = 'terlama'; open = false"
                                        class="cursor-pointer py-3 pl-4 hover:bg-green-50 text-sm font-medium text-gray-700 transition duration-200">
                                        Terlama</div>
                                    <div @click="selectedSort = 'populer'; open = false"
                                        class="cursor-pointer py-3 pl-4 hover:bg-green-50 text-sm font-medium text-gray-700 transition duration-200">
                                        Populer</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 ml-2 text-sm text-slate-400 font-medium">
                        Menampilkan <span x-text="filteredKonten.length" class="text-green-600 font-bold"></span>
                        konten edukasi
                    </div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <template x-for="item in filteredKonten" :key="item.id">
                        <a :href="item.url"
                            class="group relative bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-green-900/5 hover:-translate-y-2 transition-all duration-500 flex flex-col h-full overflow-hidden">
                            <div class="h-64 bg-slate-50 relative overflow-hidden flex items-center justify-center">
                                <template x-if="item.image">
                                    <img :src="item.image"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                </template>
                                <template x-if="!item.image">
                                    <div class="text-slate-300 flex flex-col items-center"><span
                                            class="text-sm font-medium">Visual Tidak Tersedia</span></div>
                                </template>
                                <template x-if="item.isVideo">
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition-all duration-300">
                                        <div
                                            class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-7 h-7 text-red-600 ml-1" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                </template>
                                <div class="absolute top-4 left-4 z-20">
                                    <span
                                        class="bg-green-200 backdrop-blur text-slate-800 text-[10px] font-extrabold px-3 py-1 rounded-full border border-slate-200 uppercase tracking-wider shadow-sm"
                                        x-text="item.kategori"></span>
                                </div>
                            </div>

                            <div class="p-8 flex flex-col flex-grow relative">
                                <div
                                    class="absolute top-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent group-hover:via-green-400 transition-colors duration-500">
                                </div>
                                <div class="mb-4">
                                    <span class="text-green-600 text-xs font-bold flex items-center gap-1 mb-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span x-text="item.tanggal"></span>
                                    </span>
                                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-600 transition-colors duration-300 leading-snug tracking-tight line-clamp-2"
                                        x-text="item.judul"></h3>
                                </div>
                                <p class="text-slate-500 text-sm line-clamp-3 mb-6 flex-grow leading-relaxed"
                                    x-text="item.deskripsi"></p>
                                <div class="flex items-center justify-between mt-auto pt-5 border-t border-slate-50">
                                    <div class="flex items-center gap-2">
                                        <template x-if="item.foto_penulis"><img :src="item.foto_penulis"
                                                class="w-8 h-8 rounded-full object-cover border border-slate-100"></template>
                                        <template x-if="!item.foto_penulis">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-green-400 to-emerald-500 flex items-center justify-center text-white text-xs font-bold"
                                                x-text="item.inisial_penulis"></div>
                                        </template>
                                        <span class="text-base font-semibold text-slate-600"
                                            x-text="item.penulis"></span>
                                    </div>
                                    <div class="flex items-center gap-4 text-base font-bold text-slate-400">
                                        <div class="flex items-center gap-1 text-red-500"><svg
                                                class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                            </svg><span x-text="item.likes"></span></div>
                                        <span
                                            class="text-green-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform text-lg font-bold">Baca
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>

                <div x-show="filteredKonten.length === 0"
                    class="text-center py-24 bg-white rounded-[32px] border border-dashed border-slate-300 max-w-2xl mx-auto shadow-sm mt-10">
                    <div class="bg-slate-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 01-2-2V7m2 13a2 2 0 01-2-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak Ditemukan</h3>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto">Kami tidak dapat menemukan apa yang Anda cari. Coba
                        kata kunci lain atau reset filter.</p>
                    <button @click="searchKonten = ''; selectedKategoriKonten = 'all'; selectedSort = 'terbaru'"
                        class="inline-flex items-center px-8 py-3 bg-white border-2 border-slate-200 rounded-full text-slate-700 font-bold hover:border-green-500 hover:text-green-600 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg> Reset Filter
                    </button>
                </div>
            </section>
        </div>
    </main>

    <footer class="bg-emerald-50 border-t pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/logosimbasa.png') }}" class="h-12 w-auto mr-2" alt="Logo">
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
                        <li>
                            <button @click="currentView = 'home'; window.scrollTo({top: 0, behavior: 'smooth'})"
                                class="hover:text-green-600">
                                Beranda
                            </button>
                        </li>
                        <li>
                            <button @click="currentView = 'konten'; window.scrollTo({top: 0, behavior: 'smooth'})"
                                class="hover:text-green-600">
                                Konten
                            </button>
                        </li>
                        <li>
                            <button
                                @click="currentView = 'jenis-sampah'; window.scrollTo({top: 0, behavior: 'smooth'})"
                                class="hover:text-green-600">
                                Jenis Sampah
                            </button>
                        </li>
                        <li>
                            <button
                                @click="currentView = 'home'; setTimeout(() => document.getElementById('faq')?.scrollIntoView({behavior: 'smooth'}), 300)"
                                class="hover:text-green-600">
                                FAQ
                            </button>
                        </li>
                        <li>
                            @auth
                                <a href="{{ route('dashboard') }}" class="font-bold text-green-600 hover:text-green-800">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="hover:text-green-600">
                                    Masuk
                                </a>
                            @endauth
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                            <span class="leading-relaxed">Desa Sukapura, Kab. Bandung, Jawa Barat, Indonesia</span>
                        </li>

                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>irvanmaulanaa10@gmail.com</span>
                        </li>

                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span>+62 852 6384 9464</span>
                        </li>
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
                    d="M5 10l7-7m0 0l7 7m-7-7v18">
                </path>
            </svg>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach((el) => observer.observe(el));
        });
    </script>
</body>

</html>
