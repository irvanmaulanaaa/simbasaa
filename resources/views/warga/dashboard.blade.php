<x-app-layout>
    <x-slot name="sidebar">
        @include('warga.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="p-6 lg:p-8 space-y-8 min-h-screen flex flex-col">

        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-emerald-800 shadow-xl text-white">
            <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white opacity-10 blur-3xl"></div>
            <div class="relative z-10 p-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h3 class="text-3xl font-bold">Selamat Datang, {{ Auth::user()->nama_lengkap }}! 👋</h3>
                    <p class="mt-2 text-green-50 text-lg opacity-90">
                        Ayo kelola sampahmu jadi cuan! Pantau saldo dan transaksi di sini.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Desa {{ Auth::user()->desa->nama_desa ?? '-' }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm">
                            RW {{ Auth::user()->rw }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm">
                            RT {{ Auth::user()->rt }}
                        </span>
                    </div>
                </div>
                <div class="mt-6 md:mt-0">
                    <span
                        class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm font-semibold backdrop-blur-sm border border-white border-opacity-20">
                        {{ now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div
                class="md:col-span-2 relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-500 to-emerald-700 shadow-lg text-white group hover:shadow-xl transition duration-300">
                <div
                    class="absolute right-0 top-0 h-40 w-40 -mr-10 -mt-10 rounded-full bg-white opacity-10 blur-3xl group-hover:opacity-20 transition">
                </div>
                <div class="absolute left-0 bottom-0 h-32 w-32 -ml-10 -mb-10 rounded-full bg-white opacity-10 blur-3xl">
                </div>

                <div class="relative z-10 p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 h-full">

                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-green-100 font-medium text-sm uppercase tracking-wider">Saldo Tersedia</p>
                        </div>

                        <h4 class="text-4xl font-extrabold tracking-tight">
                            Rp {{ number_format($saldo, 0, ',', '.') }}
                        </h4>

                        <p class="mt-1 text-xs text-green-100 flex items-center opacity-80">
                            Siap dicairkan kapan saja
                        </p>
                    </div>

                    <div class="flex-shrink-0">
                        <button onclick="openModal()"
                            class="w-full md:w-auto px-6 py-3 bg-white text-green-700 font-bold rounded-xl shadow-lg hover:bg-green-50 hover:scale-105 transition transform flex items-center justify-center gap-2">
                            <span>Tarik Saldo</span>
                        </button>
                    </div>

                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 flex flex-col justify-center">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                        <h4 class="text-2xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-500">
                    <span class="text-blue-600 font-bold flex items-center mr-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Akumulasi
                    </span>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 flex flex-col justify-center">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Sampah Disetor</p>

                        <div class="mt-2">
                            <h4 class="text-2xl font-bold text-gray-900 flex items-baseline">
                                {{ number_format($totalKg, 1) }}
                                <span class="text-sm font-medium text-gray-500 ml-1">Kg</span>
                            </h4>

                            @if ($totalPcs > 0)
                                <h4 class="text-2xl font-bold text-gray-700 flex items-baseline mt-1">
                                    {{ number_format($totalPcs, 0) }}
                                    <span class="text-xs font-medium text-gray-500 ml-1">Pcs</span>
                                </h4>
                            @endif
                        </div>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            Riwayat Setoran Terbaru
                        </h3>
                        <a href="{{ route('warga.setoran.index') }}"
                            class="text-sm font-medium text-green-600 hover:text-green-800 transition">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-sm">
                            <thead class="bg-gray-50 text-gray-500 uppercase font-semibold">
                                <tr>
                                    <th class="py-4 px-6 text-left w-10">No</th>
                                    <th class="py-4 px-6 text-center">Tanggal</th>
                                    <th class="py-4 px-6 text-center">Total Sampah</th>
                                    <th class="py-4 px-6 text-center">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 divide-y divide-gray-100">
                                @forelse ($riwayatSetoran as $setoran)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-4 px-6 text-center">{{ $loop->iteration }}</td>

                                        <td class="py-4 px-6 text-center">
                                            <div class="font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($setoran->tgl_setor)->translatedFormat('d M Y') }}
                                            </div>
                                        </td>

                                        <td class="py-4 px-6 text-center align-middle">
                                            @php
                                                $kg = 0;
                                                $pcs = 0;
                                                foreach ($setoran->detail as $item) {
                                                    $uom = strtolower($item->sampah->UOM ?? 'kg');
                                                    if ($uom == 'pcs') {
                                                        $pcs += $item->berat;
                                                    } else {
                                                        $kg += $item->berat;
                                                    }
                                                }
                                            @endphp

                                            <div class="flex flex-col items-center justify-center gap-1.5">
                                                @if ($kg > 0)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                        {{ floatval($kg) }} Kg
                                                    </span>
                                                @endif

                                                @if ($pcs > 0)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                        {{ floatval($pcs) }} Pcs
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="py-4 px-6 text-center">
                                            <span
                                                class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs border border-green-200">
                                                Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="bg-gray-100 p-3 rounded-full mb-3">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <span>Belum ada riwayat setoran terbaru.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full">
                    <div class="p-6 border-b border-gray-100 justify-between flex items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            Konten Terbaru
                        </h3>
                        <a href="{{ route('public.konten.index') }}"
                            class="text-sm font-medium text-green-600 hover:text-green-800 transition">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="p-4 space-y-4">
                        @forelse ($kontenTerbaru ?? [] as $edukasi)
                            @if (is_object($edukasi))
                                <div
                                    class="flex gap-4 items-start p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition duration-200">
                                    <div
                                        class="w-16 h-16 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden relative shadow-sm group">
                                        @php
                                            $mediaItem = $edukasi->media->first();
                                            $path = $mediaItem ? $mediaItem->gambar : null;
                                            $imageUrl = null;
                                            $isVideo = false;

                                            if ($path) {
                                                if (
                                                    \Illuminate\Support\Str::contains($path, [
                                                        'youtube.com',
                                                        'youtu.be',
                                                    ])
                                                ) {
                                                    $isVideo = true;
                                                    $videoId = null;

                                                    if (
                                                        preg_match(
                                                            '/(youtu\.be\/|v=|\/shorts\/|\/embed\/)([^"&?\/\s]{11})/',
                                                            $path,
                                                            $matches,
                                                        )
                                                    ) {
                                                        $videoId = $matches[2];
                                                    }

                                                    if ($videoId) {
                                                        $imageUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                                                    }
                                                }
                                                else {
                                                    $imageUrl = Storage::url($path);
                                                }
                                            }
                                        @endphp

                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}"
                                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-300"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                            @if ($isVideo)
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20">
                                                    <div class="bg-white rounded-full p-0.5 shadow-sm">
                                                        <svg class="w-3 h-3 text-red-600 ml-0.5" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif

                                            <div
                                                class="w-full h-full hidden items-center justify-center text-gray-400 bg-gray-200 absolute inset-0">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-bold text-gray-900 truncate leading-tight mb-1"
                                            title="{{ $edukasi->judul }}">
                                            {{ $edukasi->judul }}
                                        </h5>
                                        <p class="text-xs text-gray-500 mb-2 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($edukasi->deskripsi ?? 'Klik untuk baca selengkapnya.', 60) }}
                                        </p>
                                        <div class="flex items-center text-[10px] text-gray-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($edukasi->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="text-center py-8 text-gray-400">
                                <p class="text-sm">Belum ada konten edukasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
            Maulana.</p>
    </footer>

    <div id="tarikModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm"
            onclick="closeModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <div
                    class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white" id="modal-title">Form Tarik Saldo</h3>
                    <button type="button" onclick="closeModal()" class="text-green-100 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div id="loadingOverlay"
                    class="absolute inset-0 bg-white bg-opacity-90 z-50 hidden flex-col items-center justify-center rounded-lg">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
                    <p class="text-green-700 font-bold text-lg animate-pulse">Loading...</p>
                </div>

                <div class="p-6">
                    <form id="formTarikSaldo">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Jumlah Penarikan (Rp) <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">Rp</span>
                                <input type="number" id="inputJumlah" name="jumlah" min="0"
                                    onpaste="return false" placeholder="Minimal: 10000"
                                    class="w-full pl-10 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 shadow-sm transition h-10">
                            </div>

                            <p id="errorMsg" class="text-xs text-red-500 mt-1 font-medium hidden items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span id="errorText">Error message here</span>
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                Saldo maksimal: <span class="font-bold text-green-600">Rp
                                    {{ number_format($saldo, 0, ',', '.') }}</span>
                            </p>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-bold shadow-md">Kirim
                                Permintaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const maxSaldo = {{ $saldo }};
        const minPenarikan = 10000; 
        const modal = document.getElementById('tarikModal');
        const form = document.getElementById('formTarikSaldo');
        const inputJumlah = document.getElementById('inputJumlah');
        const errorMsg = document.getElementById('errorMsg');
        const errorText = document.getElementById('errorText');
        const loadingOverlay = document.getElementById('loadingOverlay');

        inputJumlah.addEventListener('keydown', function(event) {
 
            if (event.key === '-' || event.key === 'e' || event.key === '+' || event.key === 'E') {
                event.preventDefault();
            }
        });

        inputJumlah.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = Math.abs(this.value);
            }
        });

        function openModal() {
            modal.classList.remove('hidden');
            form.reset();
            hideError();
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        function showError(message) {
            errorText.innerText = message;

            errorMsg.classList.remove('hidden');
            errorMsg.classList.add('flex');

            inputJumlah.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            inputJumlah.classList.remove('border-gray-300', 'focus:ring-green-500', 'focus:border-green-500');
        }

        function hideError() {
            errorMsg.classList.add('hidden');
            errorMsg.classList.remove('flex');

            inputJumlah.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            inputJumlah.classList.add('border-gray-300', 'focus:ring-green-500', 'focus:border-green-500');
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const jumlah = parseFloat(inputJumlah.value);
            hideError();

            if (!jumlah || isNaN(jumlah)) {
                showError("Jumlah penarikan wajib diisi!");
                return;
            }

            if (jumlah < 0) {
                showError("Jumlah tidak boleh kurang dari 0!");
                return;
            }
            if (jumlah < minPenarikan) {
                showError("Minimal penarikan adalah Rp " + new Intl.NumberFormat('id-ID').format(minPenarikan));
                return;
            }

            if (jumlah > maxSaldo) {
                showError("Jumlah melebihi saldo Anda saat ini!");
                return;
            }

            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');

            const formData = new FormData(form);

            fetch("{{ route('warga.tarik.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadingOverlay.classList.add('hidden');
                    loadingOverlay.classList.remove('flex');

                    if (data.success) {
                        closeModal();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#16a34a',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('warga.penarikan.index') }}";
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    loadingOverlay.classList.add('hidden');
                    loadingOverlay.classList.remove('flex');
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Silakan coba lagi nanti.',
                        confirmButtonColor: '#dc2626'
                    });
                });
        });
    </script>
</x-app-layout>
