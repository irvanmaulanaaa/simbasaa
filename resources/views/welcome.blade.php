<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>WELCOME TO SIMBASA</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <header class="bg-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="{{ asset('images/logobaru.png') }}" alt="logo bank sampah" class="h-9 w-auto">
                    <span class="ml-2 font-bold text-xl">SIMBASA</span>
                </div>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/admin-data') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow">
                                Masuk
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="bg-white">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 items-center">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">
                        Ubah Sampah Menjadi <span class="text-green-500">Rupiah</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Selamatkan lingkungan sambil menambah pundi-pundi tabungan Anda. Bergabunglah dengan sistem bank sampah digital kami yang mudah dan transparan.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('login') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg text-lg">
                            Mulai Menabung
                        </a>
                    </div>
                </div>
                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('images/ilus.png') }}" alt="Ilustrasi bank sampah" class="w-full max-w-md">
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold">Bagaimana Caranya?</h2>
                    <p class="mt-2 text-gray-600">Hanya dengan 3 langkah mudah.</p>
                </div>
                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-medium">1. Pilah Sampah</h3>
                        <p class="mt-2 text-base text-gray-500">Pisahkan sampah anorganik (plastik, kertas, logam, dll) di rumah Anda.</p>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-medium">2. Setor ke Kami</h3>
                        <p class="mt-2 text-base text-gray-500">Bawa sampah yang sudah dipilah ke lokasi kami untuk ditimbang dan dicatat oleh admin.</p>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-500 text-white mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75-.75v-.75m0 0l-1.5-1.5m0 0l-1.5 1.5m1.5-1.5v1.5" /></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-medium">3. Cek Tabungan</h3>
                        <p class="mt-2 text-base text-gray-500">Nilai sampah Anda akan langsung dikonversi menjadi saldo yang bisa Anda cek kapan saja di sini.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-green-500 border-t">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-white">&copy; 2025 Bank Sampah Digital. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>