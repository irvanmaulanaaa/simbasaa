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
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="flex bg-white shadow-xl rounded-2xl overflow-hidden max-w-4xl w-full">
            <div class="w-1/2 bg-green-200 hidden md:flex items-center justify-center p-8 relative">
                <img src="{{ asset('images/ilus.png') }}" alt="Ilustrasi Login Bank Sampah"
                    class="max-w-full h-auto object-cover rounded-lg">
                <div class="absolute inset-0 bg-gray-300 opacity-20"></div>

            </div>

            <div class="w-full md:w-1/2 p-8 lg:p-12 relative">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
