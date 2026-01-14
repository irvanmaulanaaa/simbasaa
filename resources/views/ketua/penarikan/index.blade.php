<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Penarikan') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    <div id="global-loader"
        class="fixed inset-0 bg-white bg-opacity-90 z-[9999] flex flex-col items-center justify-center transition-opacity duration-300"
        style="display: none;">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
        <p class="text-green-700 font-bold text-lg animate-pulse">Memproses Data...</p>
    </div>

    <div class="py-6 px-4 sm:px-0 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('ketua.dashboard') }}"
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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Validasi Penarikan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-xl shadow-lg border-l-4 border-yellow-400 overflow-hidden relative">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                Permintaan Menunggu Konfirmasi
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Segera proses permintaan penarikan di bawah ini.
                            </p>
                        </div>
                        @if ($pendingRequests->isNotEmpty())
                            <span
                                class="bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full animate-pulse border border-red-200">
                                {{ $pendingRequests->count() }} Perlu Konfirmasi
                            </span>
                        @endif
                    </div>

                    <div
                        class="overflow-x-auto max-h-[400px] overflow-y-auto custom-scrollbar rounded-lg border border-gray-100 relative">
                        <table class="min-w-full bg-white relative whitespace-nowrap">
                            <thead
                                class="bg-yellow-50 text-yellow-800 uppercase text-xs font-bold sticky top-0 z-10 shadow-sm">
                                <tr>
                                    <th class="py-3 px-6 text-center w-12 bg-yellow-50">No</th>
                                    <th class="py-3 px-6 text-left bg-yellow-50">Tanggal Request</th>
                                    <th class="py-3 px-6 text-left bg-yellow-50">Nama Warga</th>
                                    <th class="py-3 px-6 text-right bg-yellow-50">Jumlah Tarik</th>
                                    <th class="py-3 px-6 text-center w-48 bg-yellow-50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse ($pendingRequests as $tarik)
                                    <tr class="border-b border-gray-50 hover:bg-yellow-50/50 transition duration-150">
                                        <td class="py-4 px-6 text-center font-bold">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6 align-middle">
                                            <div class="font-bold text-gray-800">
                                                {{ \Carbon\Carbon::parse($tarik->tgl_request)->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 align-middle">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs mr-3">
                                                    {{ substr($tarik->warga->nama_lengkap ?? '?', 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-700">
                                                        {{ $tarik->warga->nama_lengkap }}</div>
                                                    <div class="text-xs text-gray-400">RW {{ $tarik->warga->rw }} / RT
                                                        {{ $tarik->warga->rt }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 align-middle text-right">
                                            <span class="text-lg font-bold text-red-600">
                                                Rp {{ number_format($tarik->jumlah, 0, ',', '.') }}
                                            </span>
                                            @if (($tarik->warga->saldo->jumlah_saldo ?? 0) < $tarik->jumlah)
                                                <div
                                                    class="text-[10px] text-red-500 font-bold mt-1 bg-red-50 px-2 py-0.5 rounded inline-block border border-red-100">
                                                    Saldo Kurang! (Sisa:
                                                    {{ number_format($tarik->warga->saldo->jumlah_saldo ?? 0, 0, ',', '.') }})
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 align-middle text-center">
                                            <div class="flex justify-center gap-2">
                                                <form id="approve-form-{{ $tarik->id_tarik }}"
                                                    action="{{ route('ketua.penarikan.konfirmasi', $tarik->id_tarik) }}"
                                                    method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="button"
                                                        onclick="confirmAction({{ $tarik->id_tarik }}, 'setuju', {{ $tarik->jumlah }}, {{ $tarik->warga->saldo->jumlah_saldo ?? 0 }})"
                                                        class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-600 hover:text-white flex items-center justify-center transition shadow-sm border border-green-200"
                                                        title="Setujui">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form id="reject-form-{{ $tarik->id_tarik }}"
                                                    action="{{ route('ketua.penarikan.konfirmasi', $tarik->id_tarik) }}"
                                                    method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="button"
                                                        onclick="confirmAction({{ $tarik->id_tarik }}, 'tolak')"
                                                        class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition shadow-sm border border-red-200"
                                                        title="Tolak">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400 bg-gray-50/50">
                                            <div class="flex flex-col items-center">
                                                <div class="bg-gray-100 p-3 rounded-full mb-3">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <span>Semua permintaan bersih! Tidak ada antrian pending.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                                <span class="bg-blue-100 text-blue-700 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </span>
                                Riwayat Penarikan Saldo Warga
                            </h3>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('ketua.penarikan.index') }}"
                        class="grid grid-cols-1 md:grid-cols-12 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Tampilkan</label>
                            <select name="per_page" onchange="this.form.submit()"
                                class="w-full text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                </option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                </option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                </option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Data
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-4" x-data="{ searchQuery: '{{ request('search') }}' }">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Cari Nama Warga</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>

                                <input type="text" name="search" x-model="searchQuery"
                                    placeholder="Ketik nama warga..."
                                    class="w-full pl-10 pr-10 text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">

                                <button type="button" x-show="searchQuery.length > 0"
                                    @click="searchQuery = ''; $nextTick(() => $el.closest('form').submit())"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-90"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 cursor-pointer"
                                    style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="md:col-span-4 grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Dari Tanggal</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Sampai Tanggal</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>

                        <div class="md:col-span-2 flex items-end gap-2">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-sm w-full transition h-[38px]">
                                Filter
                            </button>

                            @if (request('start_date') || request('end_date') || request('search'))
                                <a href="{{ route('ketua.penarikan.index') }}"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-3 rounded-lg text-sm transition h-[38px] flex items-center justify-center animate-fade-in-up"
                                    title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white whitespace-nowrap">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                            <tr>
                                <th class="py-3 px-6 text-center w-12">No</th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Nama Warga</th>
                                <th class="py-3 px-6 text-center">Jumlah</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Dikonfirmasi Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($historyRequests as $index => $history)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                    <td class="py-3 px-6 text-center font-medium">
                                        {{ $historyRequests->firstItem() + $index }}
                                    </td>
                                    <td class="py-3 px-6">
                                        <div class="font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($history->tgl_request)->translatedFormat('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 font-medium">{{ $history->warga->nama_lengkap }}</td>
                                    <td class="py-3 px-6 text-center font-bold text-gray-700">Rp
                                        {{ number_format($history->jumlah, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($history->status == 'pending')
                                            <span
                                                class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-yellow-200">
                                                Pending
                                            </span>
                                        @elseif($history->status == 'disetujui')
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-green-200">
                                                Disetujui
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-red-200">
                                                 Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center text-xs text-gray-500">
                                        @if ($history->ketua_id)
                                            <span
                                                class="block font-semibold text-gray-700">{{ $history->ketua->nama_lengkap ?? 'Ketua' }}</span>
                                        @else
                                            <span class="italic text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-400">
                                        Data tidak ditemukan untuk pencarian/filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
                    <div class="text-xs text-gray-500">
                        Menampilkan {{ $historyRequests->firstItem() ?? 0 }} sampai {{ $historyRequests->lastItem() ?? 0 }}
                        dari {{ $historyRequests->total() }} data
                    </div>
                    <div>
                        {{ $historyRequests->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        @endif

        function confirmAction(id, type, amount = 0, balance = 0) {
            let titleText = '';
            let confirmBtnColor = '';
            let formId = '';

            if (type === 'setuju') {
                if (amount > balance) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Saldo Tidak Cukup!',
                        text: 'Saldo warga hanya Rp ' + new Intl.NumberFormat('id-ID').format(balance) +
                            ', tapi meminta Rp ' + new Intl.NumberFormat('id-ID').format(amount),
                        confirmButtonColor: '#dc2626'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Setujui Penarikan?',
                    text: 'Saldo warga akan otomatis dikurangi sebesar Rp ' + new Intl.NumberFormat('id-ID').format(
                        amount),
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        document.getElementById('approve-form-' + id).submit();
                    }
                });

            } else {
                Swal.fire({
                    title: 'Tolak Penarikan?',
                    input: 'textarea', 
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Contoh: Saldo tidak mencukupi, atau data tidak valid...',
                    inputAttributes: {
                        'aria-label': 'Tulis alasan penolakan di sini'
                    },
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Tolak Permintaan',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda wajib menuliskan alasan penolakan!'
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();

                        let form = document.getElementById('reject-form-' + id);

                        let inputPesan = document.createElement('input');
                        inputPesan.type = 'hidden';
                        inputPesan.name = 'catatan_ketua'; 
                        inputPesan.value = result.value; 

                        form.appendChild(inputPesan);
                        form.submit();
                    }
                });
            }
        }

        function showLoading() {
            document.getElementById('global-loader').style.display = 'flex';
        }
    </script>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
            Maulana.</p>
    </footer>

</x-app-layout>
