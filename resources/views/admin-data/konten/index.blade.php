<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Konten') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-data.dashboard') }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">Home</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Manajemen Konten</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                        <a href="{{ route('admin-data.konten.create') }}"
                            class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-blue-700 transition shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Konten
                        </a>

                        <form method="GET" action="{{ route('admin-data.konten.index') }}"
                            class="flex flex-wrap md:flex-nowrap gap-2 w-full md:w-auto items-center justify-end">
                            <div class="relative">
                                <select name="per_page" onchange="this.form.submit()"
                                    class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer bg-gray-50"
                                    title="Jumlah data per halaman">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                    </option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                    </option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                    </option>
                                </select>
                            </div>

                            <select name="status_id" onchange="this.form.submit()"
                                class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer w-full md:w-auto">
                                <option value="">Semua</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id_status }}"
                                        {{ request('status_id') == $status->id_status ? 'selected' : '' }}>
                                        {{ ucfirst($status->nama_status) }}</option>
                                @endforeach
                            </select>

                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full p-2 pl-10 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Cari Judul...">
                                @if (request('search'))
                                    <a href="{{ route('admin-data.konten.index', array_merge(request()->except('search'), ['search' => null])) }}"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-900 transition duration-200"
                                        title="Hapus pencarian">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-center w-12">No</th>
                                    <th class="py-3 px-6 text-left">Judul Konten</th>
                                    <th class="py-3 px-6 text-left">Pembuat</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($kontens as $index => $konten)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-6 text-center font-medium">
                                            {{ ($kontens->currentPage() - 1) * $kontens->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="py-3 px-6 text-left font-medium text-gray-900">{{ $konten->judul }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <span>{{ $konten->user->nama_lengkap ?? 'Tidak Diketahui' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            @php
                                                $statusName = strtolower($konten->status->nama_status ?? '');
                                                $color =
                                                    $statusName == 'published' || $statusName == 'aktif'
                                                        ? 'green'
                                                        : 'yellow';
                                            @endphp
                                            <span
                                                class="bg-{{ $color }}-100 text-{{ $color }}-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">{{ $konten->status->nama_status }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center space-x-2">

                                                @php
                                                    $media = $konten->media->first();
                                                    $mediaUrl = '';
                                                    $mediaType = 'none';

                                                    if ($media) {
                                                        $rawUrl = $media->gambar;
                                                        $isUrl = filter_var($rawUrl, FILTER_VALIDATE_URL);
                                                        $mediaUrl = $isUrl ? $rawUrl : asset('storage/' . $rawUrl);

                                                        if (preg_match('/(youtube\.com|youtu\.?be)/', $rawUrl)) {
                                                            $mediaType = 'youtube';
                                                        } elseif (
                                                            Str::endsWith(strtolower($rawUrl), ['.mp4', '.mov', '.avi'])
                                                        ) {
                                                            $mediaType = 'video';
                                                        } else {
                                                            $mediaType = 'image';
                                                        }
                                                    }
                                                @endphp

                                                <div id="desc-{{ $konten->id_konten }}" class="hidden">
                                                    {!! nl2br(e($konten->deskripsi)) !!}</div>

                                                <button type="button"
                                                    onclick="openDetailModal(
                                                        '{{ $konten->judul }}', 
                                                        '{{ $konten->user->nama_lengkap }}', 
                                                        '{{ $konten->status->nama_status }}', 
                                                        'desc-{{ $konten->id_konten }}',
                                                        '{{ $mediaUrl }}',
                                                        '{{ $mediaType }}'
                                                    )"
                                                    class="w-8 h-8 rounded bg-yellow-100 text-gray-600 flex items-center justify-center hover:bg-yellow-200 transition"
                                                    title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <a href="{{ route('admin-data.konten.edit', $konten->id_konten) }}"
                                                    class="w-8 h-8 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                    </svg>
                                                </a>

                                                <button type="button"
                                                    onclick="confirmDelete('{{ route('admin-data.konten.destroy', $konten->id_konten) }}', '{{ $konten->judul }}')"
                                                    class="w-8 h-8 rounded bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition"
                                                    title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-500">Data konten tidak
                                            ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $kontens->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDetailModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">

                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center border-b">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Detail Konten</h3>
                    <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-4 py-5 sm:p-6 max-h-[80vh] overflow-y-auto">

                    <div id="modal-media-container"
                        class="mb-4 rounded-lg overflow-hidden bg-black flex justify-center items-center w-full">
                    </div>

                    <div class="flex items-center space-x-3 mb-3">
                        <span id="modal-penulis"
                            class="text-sm font-medium text-gray-600 bg-blue-200 px-3 py-1 rounded-full"></span>
                        <span id="modal-status"
                            class="text-xs font-bold uppercase tracking-wide px-2 py-1 rounded-full"></span>
                    </div>

                    <h2 id="modal-judul" class="text-2xl font-bold text-gray-900 mb-2 leading-tight"></h2>

                    <div class="prose max-w-none text-gray-700 leading-relaxed text-base pt-1 mt-1"
                        id="modal-deskripsi">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingOverlay"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex-col items-center justify-center">
        <div class="bg-white p-6 rounded-2xl shadow-xl flex flex-col items-center">
            <div class="animate-spin rounded-full h-14 w-14 border-t-4 border-b-4 border-red-600 mb-4"></div>
            <p class="text-gray-800 font-bold">Loading...</p>
        </div>
    </div>
    <form id="delete-form" action="" method="POST" style="display: none;">@csrf @method('DELETE')</form>

    <script>
        function openDetailModal(judul, penulis, status, descId, mediaUrl, mediaType) {
            document.getElementById('modal-judul').innerText = judul;
            document.getElementById('modal-penulis').innerText = "Oleh: " + penulis;

            const descContent = document.getElementById(descId).innerHTML;
            document.getElementById('modal-deskripsi').innerHTML = descContent;

            const statusBadge = document.getElementById('modal-status');
            statusBadge.innerText = status;

            statusBadge.className = 'text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full border';

            if (status.toLowerCase() === 'published' || status.toLowerCase() === 'aktif') {
                statusBadge.classList.add('bg-green-100', 'text-green-800', 'border-green-200');
            } else {
                statusBadge.classList.add('bg-yellow-100', 'text-yellow-800', 'border-yellow-200');
            }

            const container = document.getElementById('modal-media-container');
            container.innerHTML = ''; 
            container.classList.remove('hidden', 'py-4'); 

            if (mediaType === 'youtube') {
                let videoId = '';
                if (mediaUrl.includes('v=')) videoId = mediaUrl.split('v=')[1].split('&')[0];
                else if (mediaUrl.includes('youtu.be/')) videoId = mediaUrl.split('youtu.be/')[1];
                else if (mediaUrl.includes('embed/')) videoId = mediaUrl.split('embed/')[1];

                if (videoId) {
                    container.innerHTML =
                        `<iframe class="w-full h-56 sm:h-80" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                }
            } else if (mediaType === 'video') {
                container.innerHTML =
                    `<video controls class="w-full max-h-80"><source src="${mediaUrl}" type="video/mp4">Browser tidak support video.</video>`;
            } else if (mediaType === 'image') {
                container.innerHTML = `<img src="${mediaUrl}" class="w-full max-h-80 object-contain">`;
            } else {
                container.classList.add('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('modal-media-container').innerHTML = '';
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        @endif

        function confirmDelete(url, judul) {
            Swal.fire({
                title: 'Hapus Konten?',
                text: "Hapus: " + judul + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('loadingOverlay').classList.remove('hidden');
                    document.getElementById('loadingOverlay').classList.add('flex');
                    var form = document.getElementById('delete-form');
                    form.action = url;
                    form.submit();
                }
            })
        }
    </script>
</x-app-layout>
