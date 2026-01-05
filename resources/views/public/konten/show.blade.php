<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $konten->judul }} - SIMBASA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-nav {
            background: rgba(246, 255, 243, 0.876);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-700">

    <nav class="glass-nav shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('public.konten.index') }}"
                    class="flex items-center text-black hover:text-green-600 transition text-lg font-bold group">
                    <svg class="w-6 h-6 mr-2 transform group-hover:-translate-x-1 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Kembali ke Konten
                </a>

                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logobaru.png') }}" alt="Logo SIMBASA"
                        class="h-14 w-auto group-hover:scale-105 transition duration-300">
                </a>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-10">

                <div class="lg:col-span-2 space-y-10">

                    <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                        @php
                            $media = $konten->media->first();
                            $path = $media
                                ? ($media->gambar && filter_var($media->gambar, FILTER_VALIDATE_URL)
                                    ? $media->gambar
                                    : Illuminate\Support\Facades\Storage::url($media->gambar))
                                : null;
                        @endphp
                        @if ($path)
                            <div class="w-full bg-gray-100 relative">
                                @if (Str::contains($path, ['.mp4', '.mov']))
                                    <video controls class="w-full rounded-t-3xl">
                                        <source src="{{ $path }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ $path }}" class="w-full h-auto object-contain">
                                @endif
                            </div>
                        @endif

                        <div class="p-8 md:p-12">
                            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-6">
                                <span
                                    class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full font-bold text-xs uppercase tracking-wide">Konten</span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($konten->created_at)->format('d F Y') }}
                                </span>
                            </div>

                            <h1
                                class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-8 leading-tight">
                                {{ $konten->judul }}
                            </h1>

                            <div class="prose prose-lg max-w-none text-slate-600 leading-relaxed">
                                {!! nl2br(e($konten->deskripsi ?? $konten->isi)) !!}
                            </div>

                            <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <button onclick="toggleLike({{ $konten->id_konten }})"
                                        class="group flex items-center space-x-3 bg-slate-50 hover:bg-red-50 px-5 py-3 rounded-full transition-all duration-300 border border-slate-200 hover:border-red-200 shadow-sm">

                                        <div class="relative">
                                            <div
                                                class="absolute -inset-2 bg-red-200 rounded-full opacity-0 group-hover:opacity-50 blur transition duration-300">
                                            </div>
                                            <svg id="heart-icon"
                                                class="relative w-7 h-7 transition duration-300 {{ $isLiked ? 'text-red-500 fill-red-500' : 'text-slate-400' }}"
                                                fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </div>

                                        <div class="flex flex-col text-left">
                                            <span id="like-text"
                                                class="text-[10px] uppercase font-bold tracking-wider {{ $isLiked ? 'text-red-600' : 'text-slate-500' }}">
                                                {{ $isLiked ? 'Disukai' : 'Suka?' }}
                                            </span>
                                            <span id="like-count"
                                                class="font-bold text-slate-800 text-lg leading-none">{{ $konten->jumlah_like }}</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-extrabold text-slate-900">Diskusi</h3>
                            <span
                                class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-sm">{{ $konten->komentars->count() }}
                                Komentar</span>
                        </div>

                        @auth
                            <form action="{{ route('public.konten.comment', $konten->id_konten) }}" method="POST"
                                class="mb-12 relative">
                                @csrf
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 h-12 w-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="flex-grow">
                                        <div class="relative">
                                            <textarea name="isi_komentar" rows="3"
                                                class="w-full border-gray-200 bg-slate-50 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white p-4 transition text-slate-700 placeholder:text-slate-400 resize-none"
                                                placeholder="Tulis pendapat Anda dengan sopan..." required></textarea>
                                        </div>
                                        <div class="mt-3 flex justify-end">
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-green-200 transition transform hover:-translate-y-0.5">
                                                Kirim Komentar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div
                                class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center mb-12">
                                <p class="text-slate-600 font-medium mb-4">Ingin bergabung dalam diskusi?</p>
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-full text-green-700 bg-green-100 hover:bg-green-200 transition">
                                    Login untuk Berkomentar
                                </a>
                            </div>
                        @endauth

                        <div class="space-y-8">
                            @forelse($konten->komentars as $komen)
                                <div class="flex space-x-4 group" id="comment-row-{{ $komen->id_komentar }}">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                        {{ substr($komen->user->nama_lengkap, 0, 1) }}
                                    </div>

                                    <div class="flex-grow">
                                        <div
                                            class="bg-slate-50 rounded-2xl p-5 border border-slate-100 group-hover:border-green-200 transition duration-300">

                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-bold text-slate-900">{{ $komen->user->nama_lengkap }}
                                                </h4>
                                                <span
                                                    class="text-xs font-medium text-slate-400">{{ $komen->created_at->diffForHumans() }}</span>
                                            </div>

                                            <p class="text-slate-600 text-sm leading-relaxed"
                                                id="comment-text-{{ $komen->id_komentar }}">
                                                {{ $komen->isi_komentar }}
                                            </p>

                                            @if (Auth::id() == $komen->user_id)
                                                <form
                                                    action="{{ route('public.komentar.update', $komen->id_komentar) }}"
                                                    method="POST" id="edit-form-{{ $komen->id_komentar }}"
                                                    class="hidden mt-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="isi_komentar" rows="2"
                                                        class="w-full text-sm border-slate-300 rounded-xl focus:ring-green-500 focus:border-green-500 mb-2 p-3">{{ $komen->isi_komentar }}</textarea>
                                                    <div class="flex space-x-2 justify-end">
                                                        <button type="button"
                                                            onclick="cancelEdit({{ $komen->id_komentar }})"
                                                            class="px-3 py-1 text-xs font-bold text-slate-500 hover:text-slate-700 bg-white border border-slate-200 rounded-lg">Batal</button>
                                                        <button type="submit"
                                                            class="px-3 py-1 text-xs font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg">Simpan</button>
                                                    </div>
                                                </form>

                                                <div class="flex justify-end mt-2 space-x-3 opacity-0 group-hover:opacity-100 transition duration-200"
                                                    id="action-buttons-{{ $komen->id_komentar }}">
                                                    <button onclick="showEditForm({{ $komen->id_komentar }})"
                                                        class="flex items-center text-xs text-slate-400 hover:text-blue-600 transition"
                                                        title="Edit Komentar">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                        Edit
                                                    </button>

                                                    <form
                                                        action="{{ route('public.komentar.delete', $komen->id_komentar) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Hapus komentar ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="flex items-center text-xs text-slate-400 hover:text-red-600 transition"
                                                            title="Hapus Komentar">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div class="inline-block p-4 bg-slate-50 rounded-full mb-3 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 font-medium">Belum ada komentar. Jadilah yang pertama!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">

                        <div
                            class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-6 text-white text-center shadow-lg relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white opacity-10 rounded-full group-hover:scale-150 transition duration-700">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 -ml-4 -mb-4 w-16 h-16 bg-white opacity-10 rounded-full">
                            </div>

                            <h3 class="text-xl font-bold mb-2 relative z-10">Punya Sampah Menumpuk?</h3>
                            <p class="text-green-50 text-sm mb-6 relative z-10">Jangan dibuang! Tukar sampahmu jadi
                                saldo tabungan sekarang juga.</p>
                        </div>

                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6"
                            x-data="{ tab: 'terbaru' }">
                            <div class="flex border-b border-gray-100 mb-4">
                                <button @click="tab = 'terbaru'"
                                    :class="{ 'text-green-600 border-b-2 border-green-600': tab === 'terbaru', 'text-slate-400 hover:text-slate-600': tab !== 'terbaru' }"
                                    class="flex-1 pb-2 text-sm font-bold transition">
                                    Terbaru
                                </button>
                                <button @click="tab = 'populer'"
                                    :class="{ 'text-green-600 border-b-2 border-green-600': tab === 'populer', 'text-slate-400 hover:text-slate-600': tab !== 'populer' }"
                                    class="flex-1 pb-2 text-sm font-bold transition">
                                    Terpopuler
                                </button>
                            </div>

                            <div x-show="tab === 'terbaru'" class="space-y-5 animate-fade-in">
                                @foreach ($beritaLain as $item)
                                    <a href="{{ route('public.konten.show', $item->id_konten) }}"
                                        class="flex group items-start">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 relative">
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
                                                <img src="{{ $sPath }}"
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <h4
                                                class="text-sm font-bold text-slate-800 group-hover:text-green-600 line-clamp-2 leading-snug transition">
                                                {{ $item->judul }}
                                            </h4>
                                            <span
                                                class="text-[10px] uppercase font-bold text-slate-400 mt-1 block tracking-wider">
                                                {{ $item->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div x-show="tab === 'populer'" class="space-y-5 animate-fade-in" style="display: none;">
                                @php
                                    $populer = \App\Models\Konten::with('media')
                                        ->whereHas('status', fn($q) => $q->where('nama_status', 'published'))
                                        ->orderBy('jumlah_like', 'desc')
                                        ->take(3)
                                        ->get();
                                @endphp
                                @foreach ($populer as $index => $item)
                                    <a href="{{ route('public.konten.show', $item->id_konten) }}"
                                        class="flex items-center group">
                                        <span
                                            class="text-2xl font-black text-slate-200 group-hover:text-green-200 mr-3 transition w-6 text-center">{{ $index + 1 }}</span>
                                        <div class="flex-grow">
                                            <h4
                                                class="text-sm font-bold text-slate-800 group-hover:text-green-600 line-clamp-2 leading-snug transition">
                                                {{ $item->judul }}
                                            </h4>
                                            <div class="flex items-center mt-1 space-x-2">
                                                <span class="text-xs text-slate-400 flex items-center">
                                                    <svg class="w-3 h-3 mr-1 text-red-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                                    </svg>
                                                    {{ $item->jumlah_like }}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-extrabold text-slate-900 text-lg mb-4">Topik Hangat</h3>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $tags = [
                                        'Plastik',
                                        'Daur Ulang',
                                        'Tutorial',
                                        'Lingkungan',
                                        'Kegiatan RW',
                                        'Harga Sampah',
                                        'Tips Hemat',
                                    ];
                                @endphp
                                @foreach ($tags as $tag)
                                    <a href="{{ route('public.konten.index', ['cari' => $tag]) }}"
                                        class="px-3 py-1.5 bg-slate-50 hover:bg-green-100 text-slate-600 hover:text-green-700 rounded-lg text-xs font-bold transition border border-slate-100">
                                        #{{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-100 rounded-3xl p-6 relative overflow-hidden">
                            <div class="absolute -right-2 -top-2 text-yellow-200 opacity-50">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                                </svg>
                            </div>
                            <h3 class="text-yellow-800 font-bold text-lg mb-2 relative z-10">Tahukah Kamu?</h3>
                            <p class="text-yellow-700 text-sm leading-relaxed relative z-10">
                                Satu botol plastik bekas membutuhkan waktu hingga <strong>450 tahun</strong> untuk
                                terurai secara alami di tanah. Yuk daur ulang!
                            </p>
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
        function toggleLike(id) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/konten/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    const countEl = document.getElementById('like-count');
                    const textEl = document.getElementById('like-text');
                    const icon = document.getElementById('heart-icon');

                    countEl.innerText = data.likes;

                    if (data.status === 'liked') {
                        icon.classList.remove('text-slate-400');
                        icon.classList.add('text-red-500', 'fill-red-500');
                        icon.setAttribute('fill', 'currentColor');
                        textEl.innerText = 'Disukai';
                        textEl.classList.remove('text-slate-500');
                        textEl.classList.add('text-red-600');

                        Swal.fire({
                            icon: 'success',
                            title: 'Disukai!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            background: '#fef2f2',
                            color: '#991b1b'
                        });
                    } else {
                        icon.classList.remove('text-red-500', 'fill-red-500');
                        icon.classList.add('text-slate-400');
                        icon.setAttribute('fill', 'none');
                        textEl.innerText = 'Suka?';
                        textEl.classList.remove('text-red-600');
                        textEl.classList.add('text-slate-500');

                        Swal.fire({
                            icon: 'info',
                            title: 'Batal Suka',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function showEditForm(id) {
            document.getElementById(`comment-text-${id}`).classList.add('hidden');
            document.getElementById(`action-buttons-${id}`).classList.add('hidden');
            document.getElementById(`edit-form-${id}`).classList.remove('hidden');
        }

        function cancelEdit(id) {
            document.getElementById(`comment-text-${id}`).classList.remove('hidden');
            document.getElementById(`action-buttons-${id}`).classList.remove('hidden');
            document.getElementById(`edit-form-${id}`).classList.add('hidden');
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                background: '#f0fdf4',
                color: '#166534'
            });
        @endif
    </script>

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
