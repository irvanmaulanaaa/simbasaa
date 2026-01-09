<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                {{-- Hamburger Menu untuk Mobile --}}
                <div class="flex items-center lg:hidden">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <x-heroicon-o-bars-3-center-left class="h-6 w-6" />
                    </button>
                </div>

                {{-- Breadcrumbs / Header --}}
                <div class="ml-3 lg:ml-0">
                    @if (isset($breadcrumbs))
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                {{ $breadcrumbs }}
                            </ol>
                        </nav>
                    @elseif (isset($header))
                        {{ $header }}
                    @endif
                </div>
            </div>

            <div class="flex items-center sm:ms-6 space-x-3">

                {{-- Tombol Notifikasi (Lonceng) --}}
                <button class="p-1 rounded-full text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                {{-- Bagian Profil User --}}
                <div class="flex items-center space-x-3 cursor-default select-none pl-2 border-l border-gray-200">

                    {{-- LOGIKA FOTO PROFIL VS INISIAL --}}
                    @if (Auth::user()->profile_photo_path)
                        {{-- JIKA ADA FOTO --}}
                        <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" 
                             alt="{{ Auth::user()->nama_lengkap }}"
                             class="h-9 w-9 rounded-full object-cover shadow-sm border-2 border-white ring-1 ring-gray-100">
                    @else
                        {{-- JIKA TIDAK ADA FOTO (Inisial) --}}
                        <div class="h-9 w-9 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-sm shadow-sm border-2 border-white ring-1 ring-gray-100">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif

                    {{-- Nama & Username --}}
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="font-bold text-sm text-gray-800 leading-tight">
                            {{ Auth::user()->nama_lengkap }}
                        </span>
                        <span class="text-xs text-gray-500 font-medium">
                            {{ Auth::user()->username }} 
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>
