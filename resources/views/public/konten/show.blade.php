<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $konten->judul }} - SIMBASA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-700">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('public.konten.index') }}"
                    class="flex items-center text-gray-600 hover:text-green-600 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Arsip
                </a>
                <a href="{{ url('/') }}" class="font-bold text-xl text-green-600">SIMBASA</a>
            </div>
        </div>
    </nav>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">

                    <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        @php
                            $media = $konten->media->first();
                            $path = $media
                                ? ($media->gambar && filter_var($media->gambar, FILTER_VALIDATE_URL)
                                    ? $media->gambar
                                    : Illuminate\Support\Facades\Storage::url($media->gambar))
                                : null;
                        @endphp
                        @if ($path)
                            <div class="w-full h-auto bg-gray-100">
                                @if (Str::contains($path, ['.mp4', '.mov']))
                                    <video controls class="w-full">
                                        <source src="{{ $path }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ $path }}" class="w-full object-cover">
                                @endif
                            </div>
                        @endif

                        <div class="p-6 md:p-10">
                            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                                <span
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-xs uppercase tracking-wide">Artikel</span>
                                <span>{{ \Carbon\Carbon::parse($konten->created_at)->format('d F Y') }}</span>
                            </div>

                            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                                {{ $konten->judul }}</h1>

                            <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                                {!! nl2br(e($konten->deskripsi ?? $konten->isi)) !!}
                            </div>

                            <div class="mt-10 pt-8 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <button onclick="likeContent({{ $konten->id_konten }})"
                                        class="group flex items-center space-x-2 bg-gray-100 hover:bg-red-50 px-4 py-2 rounded-full transition-all duration-300">
                                        <div
                                            class="p-2 bg-white rounded-full shadow-sm group-hover:scale-110 transition">
                                            <svg id="heart-icon"
                                                class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col text-left">
                                            <span class="text-xs text-gray-500 font-semibold uppercase">Suka Konten
                                                Ini?</span>
                                            <span id="like-count"
                                                class="font-bold text-gray-800 text-lg">{{ $konten->jumlah_like }}</span>
                                        </div>
                                    </button>
                                </div>
                                <div class="text-sm text-gray-400 italic">
                                    Bagikan ke teman Anda
                                </div>
                            </div>
                        </div>
                    </article>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            Diskusi
                            <span
                                class="ml-2 bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full">{{ $konten->komentars->count() }}</span>
                        </h3>

                        @auth
                            <form action="{{ route('public.konten.comment', $konten->id_konten) }}" method="POST"
                                class="mb-10">
                                @csrf
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                                        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="flex-grow">
                                        <textarea name="isi_komentar" rows="3"
                                            class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 shadow-sm p-3"
                                            placeholder="Tulis pendapat Anda yang sopan..." required></textarea>
                                        <div class="mt-2 flex justify-end">
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition">Kirim
                                                Komentar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center mb-10">
                                <p class="text-blue-800 font-medium mb-3">Ingin bergabung dalam diskusi?</p>
                                <a href="{{ route('login') }}"
                                    class="inline-block bg-white text-blue-600 border border-blue-200 hover:bg-blue-50 px-6 py-2 rounded-lg font-bold transition">
                                    Log in untuk Komentar
                                </a>
                            </div>
                        @endauth

                        <div class="space-y-6">
                            @forelse($konten->komentars as $komen)
                                <div class="flex space-x-4">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                        {{ substr($komen->user->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="flex-grow bg-gray-50 rounded-2xl p-4">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-bold text-gray-900">{{ $komen->user->nama_lengkap }}</h4>
                                            <span
                                                class="text-xs text-gray-400">{{ $komen->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 text-sm leading-relaxed">{{ $komen->isi_komentar }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-400 italic py-4">Belum ada komentar. Jadilah yang
                                    pertama!</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-bold text-gray-900 text-lg mb-4 pb-2 border-b">Berita Lainnya</h3>
                            <div class="space-y-4">
                                @foreach ($beritaLain as $item)
                                    <a href="{{ route('public.konten.show', $item->id_konten) }}" class="flex group">
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                            @php
                                                $sMedia = $item->media->first();
                                                $sPath = $sMedia
                                                    ? ($sMedia->gambar &&
                                                    filter_var($sMedia->gambar, FILTER_VALIDATE_URL)
                                                        ? $sMedia->gambar
                                                        : Illuminate\Support\Facades\Storage::url($sMedia->gambar))
                                                    : null;
                                            @endphp
                                            @if ($sPath)
                                                <img src="{{ $sPath }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <h4
                                                class="text-sm font-semibold text-gray-800 group-hover:text-green-600 line-clamp-2">
                                                {{ $item->judul }}</h4>
                                            <span
                                                class="text-xs text-gray-400 mt-1 block">{{ $item->created_at->format('d M Y') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-green-500 border-t">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-white text-lg">&copy; {{ date('Y') }} SIMBASA. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function likeContent(id) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const btn = document.querySelector('button[onclick="likeContent(' + id + ')"]');
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            fetch(`/konten/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');

                    if (data.status === 'success') {
                        const countEl = document.getElementById('like-count');
                        if (countEl) countEl.innerText = data.likes;

                        const icon = document.getElementById('heart-icon');
                        if (icon) {
                            icon.classList.remove('text-gray-400');
                            icon.classList.add('text-red-500', 'scale-125'); 
                            setTimeout(() => icon.classList.remove('scale-125'), 200);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Terima Kasih!',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            background: '#f0fdf4',
                            color: '#166534' 
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Oops...',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan jaringan. Coba lagi nanti.',
                    });
                });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
</body>

</html>
