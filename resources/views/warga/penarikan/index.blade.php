<x-app-layout>
    <x-slot name="sidebar">
        @include('warga.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penarikan') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="p-6 lg:p-8 space-y-8 min-h-screen flex flex-col">

        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('warga.dashboard') }}"
                        class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Riwayat Penarikan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Dicairkan</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">
                        Rp
                        {{ number_format(\App\Models\Penarikan::where('warga_id', Auth::id())->where('status', 'disetujui')->sum('jumlah'), 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Menunggu Konfirmasi</p>
                    <h3 class="text-2xl font-bold text-yellow-600 mt-1">
                        {{ \App\Models\Penarikan::where('warga_id', Auth::id())->where('status', 'pending')->count() }}
                        <span class="text-sm text-gray-400 font-normal">Permintaan</span>
                    </h3>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div
                class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 rounded-2xl shadow-md text-white flex items-center justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 h-full w-24 bg-white opacity-10 skew-x-12 translate-x-10"></div>
                <div class="relative z-10">
                    <p class="text-sm text-green-100 font-medium">Sisa Saldo Anda</p>
                    <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                </div>
                <div class="relative z-10 p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Permintaan Penarikan Saldo</h3>
                </div>

                <form method="GET" action="{{ route('warga.penarikan.index') }}" class="mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tampilkan</label>
                            <select name="per_page" onchange="this.form.submit()"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                </option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                </option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <select name="status" onchange="this.form.submit()"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                                    Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-5 grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>

                        <div class="md:col-span-2 flex gap-2">
                            <button type="submit"
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                Filter
                            </button>
                            @if (request()->anyFilled(['status', 'start_date', 'end_date']))
                                <a href="{{ route('warga.penarikan.index') }}"
                                    class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition flex items-center justify-center"
                                    title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-500 uppercase font-semibold border-b border-gray-100">
                        <tr>
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6 text-center">Tanggal Request</th>
                            <th class="py-4 px-6 text-left">Jumlah</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Tanggal Konfirmasi</th>
                            <th class="py-4 px-6 text-center w-24">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-100">
                        @forelse ($riwayat as $index => $item)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-6 text-center font-medium">{{ $riwayat->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-800 text-center">
                                        {{ \Carbon\Carbon::parse($item->tgl_request)->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-700 text-base">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($item->status == 'pending')
                                        <span
                                            class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200">
                                            Pending
                                        </span>
                                    @elseif($item->status == 'disetujui')
                                        <span
                                            class="inline-flex items-center bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-500 text-center">
                                    @if ($item->tgl_konfirmasi)
                                        {{ \Carbon\Carbon::parse($item->tgl_konfirmasi)->translatedFormat('d M Y') }}
                                    @else
                                        <span class="text-gray-300 italic">- Menunggu -</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center relative">
                                    @php
                                        $statusAman = strtolower($item->status);
                                    @endphp

                                    @if ($statusAman == 'ditolak')
                                        <button
                                            onclick="showReason('{{ $item->catatan_ketua ?? 'Tidak ada alasan spesifik.' }}', '{{ $item->id_tarik }}')"
                                            class="group relative inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition shadow-sm border border-red-100"
                                            title="Lihat Alasan">

                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>

                                            @if ($item->is_read == 0)
                                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                                    <span
                                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span
                                                        class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                                                </span>
                                            @endif
                                        </button>
                                    @elseif($statusAman == 'disetujui')
                                        <div
                                            class="text-green-500 bg-green-50 p-1.5 rounded-full inline-flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <span class="text-gray-300 font-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-16 text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="font-medium text-gray-500">Belum ada riwayat penarikan.</p>
                                        <p class="text-xs mt-1">Ajukan penarikan saldo melalui dashboard.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $riwayat->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
            Maulana.</p>
    </footer>

    <script>
        function showReason(message, id) {

            Swal.fire({
                title: 'Alasan Penolakan',
                text: message,
                icon: 'info',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#3b82f6',
                background: '#fff',
                iconColor: '#ef4444',
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    title: 'text-lg font-bold text-gray-800',
                    confirmButton: 'rounded-lg px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    window.location.reload();
                }
            });

            if (id) {
                const url = "{{ url('/warga/penarikan') }}/" + id + "/mark-read";
                console.log("Mengirim request ke:", url); 

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            console.error("Gagal update status. Server error:", response.status);
                        } else {
                            console.log("Berhasil! Database sudah diupdate.");
                        }
                    })
                    .catch(error => console.error('Error Fetch:', error));
            }
        }
    </script>
</x-app-layout>
