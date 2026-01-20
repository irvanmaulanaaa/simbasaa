<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') |
        @endif{{ config('app.name', 'SIMBASA') }}
    </title>

    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-sans antialiased">

    <div x-data="{ sidebarOpen: false }" class="h-screen bg-gray-100 flex overflow-hidden">

        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black opacity-50 transition-opacity lg:hidden" x-cloak></div>

        @if (isset($sidebar))
            <aside
                class="fixed inset-y-0 left-0 z-50 w-64 bg-white text-gray-900 border-r border-gray-200 transform transition-transform duration-300 ease-in-out 
                           lg:relative lg:translate-x-0 lg:flex-shrink-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>

                <div class="h-full flex flex-col">
                    <div class="h-16 flex items-center shadow-sm border-b border-gray-100 relative">
                        <img src="{{ asset('images/logosimbasa.png') }}" alt="SIMBASA" class="h-10 w-auto ml-6">
                        <span class="text-gray-800 text-xl font-bold ml-4">SIMBASA</span>
                        <button @click="sidebarOpen = false"
                            class="absolute top-3 right-3 p-1 text-gray-400 hover:text-gray-600 lg:hidden">
                            <svg class="h-6 w-6 mt-1" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto flex flex-col">
                        {{ $sidebar }}
                    </nav>
                </div>
            </aside>
        @endif

        <div class="flex-1 flex flex-col w-0">

            @include('layouts.navigation', ['header' => $header ?? null])

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
