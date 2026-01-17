<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bank Sampah') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-100 p-4">
        
        <div class="flex bg-white shadow-2xl rounded-2xl overflow-hidden max-w-4xl w-full border border-white/50">

            <div class="w-1/2 bg-green-300 hidden md:flex items-center justify-center p-8 relative">
                <img src="{{ asset('images/ilus.png') }}" alt="Ilustrasi Login Bank Sampah"
                    class="max-w-full h-auto object-cover rounded-xl relative z-10 hover:scale-105 transition duration-500">
                
                <div class="absolute inset-0 bg-green-100 opacity-30"></div>
            </div>

            <div class="w-full md:w-1/2 p-8 lg:p-12 relative flex flex-col justify-center">
                {{ $slot }}
            </div>
        </div>
        
        <div class="absolute bottom-4 text-xs text-green-800 opacity-60">
            &copy; {{ date('Y') }} SIMBASA
        </div>
    </div>
</body>

</html>
