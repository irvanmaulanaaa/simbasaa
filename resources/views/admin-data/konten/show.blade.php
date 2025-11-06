<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Konten') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-data.dashboard') }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin-data.konten.index') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Manajemen
                                Konten</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-10 text-gray-900">

                    <h1 class="text-4xl font-bold mb-4">{{ $konten->judul }}</h1>

                    <div class="flex items-center text-sm text-gray-500 mb-6">
                        <span>Dibuat oleh: {{ $konten->user->nama_lengkap }}</span>
                        <span class="mx-2">|</span>
                        @if($konten->status->nama_status == 'published')
                            <span class="font-semibold text-green-600">Published</span>
                        @else
                            <span class="font-semibold text-yellow-600">Draft</span>
                        @endif
                    </div>

                    @php
                        $media = $konten->media->first();
                    @endphp

                    @if($media)
                        <div class="mb-6 rounded-lg overflow-hidden shadow-lg">
                            @php
                                $isUrl = filter_var($media->gambar, FILTER_VALIDATE_URL);
                                $path = $isUrl ? $media->gambar : Illuminate\Support\Facades\Storage::url($media->gambar);
                            @endphp

                            @if(Str::contains($path, ['.jpg', '.jpeg', '.png', '.gif']))
                                <img src="{{ $path }}" alt="{{ $konten->judul }}" class="w-full h-auto object-cover">
                            
                            @elseif(Str::contains($path, ['.mp4', '.mov', '.avi']))
                                <video controls class="w-full">
                                    <source src="{{ $path }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            
                            @elseif($isUrl)
                                <div class="p-4 bg-gray-100">
                                    <a href="{{ $path }}" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-900">
                                        Lihat Media Eksternal: {{ $path }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="prose max-w-none text-lg">
                        {!! nl2br(e($konten->deskripsi)) !!}
                    </div>

                    <div class="mt-8 border-t pt-6">
                        <a href="{{ route('admin-data.konten.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            &larr; Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>