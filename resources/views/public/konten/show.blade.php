<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $konten->judul }} - SIMBASA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(246, 255, 243, 0.876);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .article-body {
            font-family: 'Merriweather', serif; 
            color: #334155; 
            line-height: 2; 
            font-size: 1.125rem; 
        }
        .article-body p { margin-bottom: 2em; }
        .article-body p:first-of-type::first-letter {
            float: left;
            font-size: 3.5rem;
            line-height: 0.85;
            font-weight: 700;
            margin-right: 0.5rem;
            color: #16a34a; 
        }
        .image-zoom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .image-zoom-modal.active {
            display: flex;
            opacity: 1;
        }
        .image-zoom-modal img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        .image-zoom-modal.active img {
            transform: scale(1);
        }
        .zoom-controls {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 10000;
        }
        .zoom-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .zoom-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }
        .video-fullscreen-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            color: white;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 10;
        }
        .video-fullscreen-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: translateY(-2px);
        }
        .zoom-cursor { cursor: zoom-in; }
        .zoom-cursor:hover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.1);
            border-radius: inherit;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-[#FAFAFA] font-sans antialiased text-gray-700 selection:bg-green-100 selection:text-green-800">

    <nav class="glass-nav shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('public.konten.index') }}" class="flex items-center text-black hover:text-green-600 transition text-lg font-bold group">
                    <svg class="w-6 h-6 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Konten
                </a>
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logobaru.png') }}" alt="Logo SIMBASA" class="h-14 w-auto group-hover:scale-105 transition duration-300">
                </a>
            </div>
        </div>
    </nav>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12">
                <div class="lg:col-span-8">
                    @php
                        $media = $konten->media->first();
                        $mediaHtml = null;
                        if ($media) {
                            $path = $media->gambar;
                            if ($media->tipe == 'youtube' || strpos($path, 'youtube.com') !== false || strpos($path, 'youtu.be') !== false) {
                                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $path, $matches);
                                $videoId = $matches[1] ?? null;
                                if($videoId) {
                                    $mediaHtml = '<div id="video-container" class="relative w-full aspect-video rounded-[2rem] overflow-hidden shadow-xl mb-8 group ring-1 ring-slate-900/5">
                                                    <iframe id="youtube-iframe" src="https://www.youtube.com/embed/'.$videoId.'" 
                                                        class="absolute top-0 left-0 w-full h-full" 
                                                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                                    </iframe>
                                                  </div>';
                                }
                            } else {
                                $imgUrl = filter_var($path, FILTER_VALIDATE_URL) ? $path : Illuminate\Support\Facades\Storage::url($path);
                                $mediaHtml = '<div class="relative w-full rounded-[2rem] overflow-hidden shadow-xl mb-8 ring-1 ring-slate-900/5 zoom-cursor group" onclick="openImageZoom(\''.$imgUrl.'\')">
                                                <img src="'.$imgUrl.'" class="w-full h-auto object-contain bg-white transition-transform duration-300 group-hover:scale-105" alt="'.$konten->judul.'">
                                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none"></div>
                                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-full text-xs font-bold text-gray-700 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                    </svg>
                                                    Klik untuk Perbesar
                                                </div>
                                              </div>';
                            }
                        }
                    @endphp
                    {!! $mediaHtml !!}

                    <header class="mb-10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-xs uppercase tracking-wider">
                                    {{ $konten->kategoriKonten->nama_kategori }}
                                </span>

                                <span class="text-slate-400 text-sm font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($konten->created_at)->format('d F Y') }}
                                </span>
                            </div>
                            <button onclick="toggleLike({{ $konten->id_konten }})" class="flex items-center space-x-2 group px-4 py-1.5 rounded-full bg-white border border-slate-200 hover:border-red-200 hover:bg-red-50 transition-all duration-300 shadow-sm">
                                <svg id="heart-icon" class="w-5 h-5 transition-all duration-300 {{ $isLiked ? 'text-red-500 fill-red-500' : 'text-slate-400 group-hover:text-red-500' }}" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span id="like-count" class="font-bold text-slate-700 text-sm group-hover:text-red-600 ml-1">{{ $konten->jumlah_like }}</span>
                            </button>
                        </div>
                        <h1 class="text-3xl font-bold text-slate-900 leading-[1.15] tracking-tight mb-4">{{ $konten->judul }}</h1>
                    </header>

                    <article class="article-body prose prose-lg max-w-none mb-10">
                        {!! nl2br(e($konten->deskripsi ?? $konten->isi)) !!}
                    </article>

                    <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-black text-slate-900">Komentar</h3>
                            <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-sm">{{ $konten->komentars->count() }} Komentar</span>
                        </div>

                        @auth
                            <form action="{{ route('public.konten.comment', $konten->id_konten) }}" method="POST" class="mb-12 flex gap-4">
                                @csrf
                                <div class="flex-shrink-0 hidden md:block">
                                    <div class="w-12 h-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <textarea name="isi_komentar" rows="3" class="w-full border-gray-200 bg-slate-50 rounded-2xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white p-4 transition text-slate-700 placeholder:text-slate-400 resize-none shadow-inner" placeholder="Bagikan pendapat Anda..." required></textarea>
                                    <div class="mt-3 flex justify-end">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-green-200 transition transform hover:-translate-y-0.5">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center mb-12">
                                <p class="text-slate-600 font-medium mb-4 text-lg">Ingin bergabung dalam diskusi?</p>
                                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-bold rounded-full text-green-700 bg-green-100 hover:bg-green-200 transition shadow-sm">Login untuk Berkomentar</a>
                            </div>
                        @endauth

                        <div class="space-y-8">
                            @forelse($konten->komentars as $komen)
                                <div class="flex space-x-4 group">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                        {{ substr($komen->user->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="flex-grow">
                                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 group-hover:border-green-200 transition duration-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-bold text-slate-900">{{ $komen->user->nama_lengkap }}</h4>
                                                <span class="text-xs font-medium text-slate-400">{{ $komen->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-slate-600 text-sm leading-relaxed" id="comment-text-{{ $komen->id_komentar }}">{{ $komen->isi_komentar }}</p>

                                            @if (Auth::id() == $komen->user_id)
                                                <form action="{{ route('public.komentar.update', $komen->id_komentar) }}" method="POST" id="edit-form-{{ $komen->id_komentar }}" class="hidden mt-3">
                                                    @csrf @method('PUT')
                                                    <textarea name="isi_komentar" rows="2" class="w-full text-sm border-slate-300 rounded-xl focus:ring-green-500 focus:border-green-500 mb-2 p-3 bg-white">{{ $komen->isi_komentar }}</textarea>
                                                    <div class="flex space-x-2 justify-end">
                                                        <button type="button" onclick="cancelEdit({{ $komen->id_komentar }})" class="px-3 py-1 text-xs font-bold text-slate-500 hover:text-slate-700 bg-white border border-slate-200 rounded-lg">Batal</button>
                                                        <button type="submit" class="px-3 py-1 text-xs font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg">Simpan</button>
                                                    </div>
                                                </form>
                                                <div class="flex justify-end mt-2 space-x-3 opacity-0 group-hover:opacity-100 transition duration-200" id="action-buttons-{{ $komen->id_komentar }}">
                                                    <button onclick="showEditForm({{ $komen->id_komentar }})" class="flex items-center text-xs text-slate-400 hover:text-blue-600 transition font-bold">Edit</button>
                                                    <form action="{{ route('public.komentar.delete', $komen->id_komentar) }}" method="POST" class="inline" onsubmit="return confirm('Hapus komentar ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="flex items-center text-xs text-slate-400 hover:text-red-600 transition font-bold">Hapus</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                    <div class="inline-block p-4 bg-white rounded-full mb-3 text-slate-300 shadow-sm">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium">Belum ada komentar. Jadilah yang pertama!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="sticky top-24 space-y-8">
                        <div class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-150 transition duration-1000"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-yellow-300 opacity-10 rounded-full blur-2xl"></div>
                            <div class="relative z-10">
                                <h3 class="text-2xl font-black mb-3 tracking-tight">Dukung Gerakan Hijau!</h3>
                                <p class="text-green-50 text-sm mb-8 leading-relaxed font-medium">Satu langkah kecil untuk lingkungan, lompatan besar untuk masa depan. Mari berkontribusi bersama kami!</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6" x-data="{ tab: 'terbaru' }">
                            <div class="flex border-b border-gray-100 mb-6">
                                <button @click="tab = 'terbaru'" :class="{ 'text-green-600 border-b-2 border-green-600': tab === 'terbaru', 'text-slate-400 hover:text-slate-600': tab !== 'terbaru' }" class="flex-1 pb-3 text-sm font-bold transition">Terbaru</button>
                                <button @click="tab = 'populer'" :class="{ 'text-green-600 border-b-2 border-green-600': tab === 'populer', 'text-slate-400 hover:text-slate-600': tab !== 'populer' }" class="flex-1 pb-3 text-sm font-bold transition">Populer</button>
                            </div>

                            <div x-show="tab === 'terbaru'" class="space-y-6">
                                @foreach ($beritaLain as $item)
                                    <a href="{{ route('public.konten.show', $item->id_konten) }}" class="flex gap-4 group">
                                        <div class="w-24 h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-gray-100 relative shadow-sm">
                                            @php
                                                $sMedia = $item->media->first();
                                                $sPath = null;
                                                if ($sMedia) {
                                                    if (strpos($sMedia->gambar, 'youtube') !== false || strpos($sMedia->gambar, 'youtu.be') !== false) {
                                                        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $sMedia->gambar, $m);
                                                        $vid = $m[1] ?? null;
                                                        $sPath = $vid ? "https://img.youtube.com/vi/{$vid}/default.jpg" : null;
                                                    } else {
                                                        $sPath = filter_var($sMedia->gambar, FILTER_VALIDATE_URL) ? $sMedia->gambar : Illuminate\Support\Facades\Storage::url($sMedia->gambar);
                                                    }
                                                }
                                            @endphp
                                            @if($sPath)
                                                <img src="{{ $sPath }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="text-sm font-bold text-slate-800 group-hover:text-green-600 leading-snug line-clamp-2 transition mb-1">{{ $item->judul }}</h4>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">{{ $item->created_at->format('d M Y') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div x-show="tab === 'populer'" class="space-y-6" style="display: none;">
                                @php
                                    $populer = \App\Models\Konten::with('media')->whereHas('status', fn($q) => $q->where('nama_status', 'published'))->orderBy('jumlah_like', 'desc')->take(4)->get();
                                @endphp
                                @foreach ($populer as $idx => $item)
                                    <a href="{{ route('public.konten.show', $item->id_konten) }}" class="flex items-center gap-4 group">
                                        <span class="text-3xl font-black text-slate-200 group-hover:text-green-200 transition w-8 text-center italic">{{ $idx + 1 }}</span>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800 group-hover:text-green-600 leading-snug line-clamp-2 transition">{{ $item->judul }}</h4>
                                            <div class="flex items-center gap-1 mt-1 text-xs text-slate-400 font-medium">
                                                <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" /></svg>
                                                {{ $item->jumlah_like }} Suka
                                            </div>
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

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan Maulana. All rights reserved.</p>
    </footer>

    <div id="imageZoomModal" class="image-zoom-modal" onclick="closeImageZoom()">
        <div class="zoom-controls">
            <button class="zoom-btn" onclick="event.stopPropagation(); closeImageZoom()" title="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <button class="zoom-btn" onclick="event.stopPropagation(); downloadImage()" title="Download">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
            </button>
        </div>
        <img id="zoomedImage" src="" alt="Zoomed Image" onclick="event.stopPropagation()">
    </div>

    <script>
        let currentImageSrc = '';

        function openImageZoom(imgSrc) {
            currentImageSrc = imgSrc;
            const modal = document.getElementById('imageZoomModal');
            const img = document.getElementById('zoomedImage');
            img.src = imgSrc;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeImageZoom() {
            const modal = document.getElementById('imageZoomModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        function downloadImage() {
            const link = document.createElement('a');
            link.href = currentImageSrc;
            link.download = 'image-simbasa.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageZoom();
            }
        });

        function toggleLike(id) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/konten/${id}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'Content-Type': 'application/json' },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                const countEl = document.getElementById('like-count');
                const icon = document.getElementById('heart-icon');
                countEl.innerText = data.likes;
                if (data.status === 'liked') {
                    icon.classList.remove('text-slate-400', 'group-hover:text-red-500');
                    icon.classList.add('text-red-500', 'fill-red-500');
                    icon.setAttribute('fill', 'currentColor');
                    Swal.fire({ icon: 'success', title: 'Disukai!', toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, background: '#fef2f2', color: '#991b1b' });
                } else {
                    icon.classList.remove('text-red-500', 'fill-red-500');
                    icon.classList.add('text-slate-400');
                    icon.setAttribute('fill', 'none');
                    Swal.fire({ icon: 'info', title: 'Batal Suka', toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                @guest
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Silakan login terlebih dahulu untuk menyukai konten ini!',
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                @endguest
            });
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
            </svg>
        </button>
    </div>

</body>

</html>
