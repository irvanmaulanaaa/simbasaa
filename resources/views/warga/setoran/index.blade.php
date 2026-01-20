<x-app-layout>

    @section('title', 'Setoran Sampah')

    <x-slot name="sidebar">
        @include('warga.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Setoran') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-8 space-y-8 min-h-screen flex flex-col">

        <nav class="flex mb-4" aria-label="Breadcrumb">
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
                        <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Riwayat Setoran</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 h-full w-24 bg-white opacity-10 skew-x-12 translate-x-10"></div>
                <p class="text-sm text-green-100 font-medium">Total Uang Dihasilkan</p>
                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <div class="absolute bottom-4 right-4 p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Sampah Disetor</p>
                    <div class="flex flex-col mt-1">
                        <span class="text-xl font-bold text-gray-900">
                            {{ number_format($totalKg, 2) }} <span class="text-sm font-normal text-gray-500">Kg</span>
                        </span>
                        @if ($totalPcs > 0)
                            <span class="text-xl font-bold text-gray-700">
                                {{ number_format($totalPcs, 0) }} <span
                                    class="text-xs font-normal text-gray-500">Pcs</span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl h-fit">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                        </path>
                    </svg>
                </div>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Melakukan Setoran</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $setorans->total() }} <span class="text-sm font-normal text-gray-500">Kali</span>
                    </h3>
                </div>
                <div class="p-3 mt-4 bg-orange-50 text-orange-600 rounded-xl h-fit">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Riwayat Setoran Sampah</h3>

                <form method="GET" action="{{ route('warga.setoran.index') }}" class="mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tampilkan</label>
                            <select name="per_page" onchange="this.form.submit()"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data
                                </option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                </option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                </option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-8 grid grid-cols-2 gap-2">
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
                            @if (request()->anyFilled(['start_date', 'end_date']))
                                <a href="{{ route('warga.setoran.index') }}"
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
                            <th class="py-4 px-6 text-center w-12">No</th>
                            <th class="py-4 px-6 text-center">Tanggal</th>
                            <th class="py-4 px-6 text-center">Rincian Sampah</th>
                            <th class="py-4 px-6 text-center">Total Pendapatan</th>
                            <th class="py-4 px-6 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-100">
                        @forelse ($setorans as $index => $setoran)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-center font-medium text-gray-400">
                                    {{ $setorans->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($setoran->tgl_setor)->translatedFormat('d M Y') }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800 items-center">

                                            {{ $setoran->detail->count() }} Jenis Sampah
                                        </span>
                                        <span class="text-xs text-gray-500 mt-1">
                                            {{ $setoran->detail->first()->sampah->nama_sampah ?? '-' }}
                                            @if ($setoran->detail->count() > 1)
                                                dan {{ $setoran->detail->count() - 1 }} lainnya
                                            @endif
                                        </span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="text-green-600 font-bold text-base bg-green-50 px-3 py-1 rounded-lg border border-green-100">
                                        Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 text-left">
                                    <button onclick='showDetail(@json($setoran))'
                                        class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-full transition shadow-sm border border-blue-100"
                                        title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="font-medium text-gray-600">Belum ada riwayat setoran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $setorans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
            Maulana.</p>
    </footer>

    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm"
            onclick="closeModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white" id="modal-title">Detail Setoran</h3>
                    <button onclick="closeModal()" class="text-green-100 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-6">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Tanggal Transaksi</p>
                            <p id="modalDate" class="text-gray-900 font-medium mt-1">...</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Harga</p>
                            <p id="modalTotal" class="text-green-600 font-bold text-lg mt-1">...</p>
                        </div>
                    </div>

                    <h4 class="text-sm font-bold text-gray-700 mb-3">Item Sampah:</h4>
                    <div id="modalItems" class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(data) {
            const date = new Date(data.tgl_setor);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            document.getElementById('modalDate').innerText = date.toLocaleDateString('id-ID', options);

            document.getElementById('modalTotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(data
                .total_harga);

            const itemsContainer = document.getElementById('modalItems');
            itemsContainer.innerHTML = '';

            data.detail.forEach(item => {
                const namaSampah = item.sampah ? item.sampah.nama_sampah : 'Sampah Terhapus';
                const uom = item.sampah ? item.sampah.UOM : 'Kg';
                const hargaPerUnit = item.sampah ? item.sampah.harga_anggota : 0;
                const subtotal = item.subtotal || (item.berat * hargaPerUnit);

                const itemHtml = `
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <div class="flex items-center">
                            <div class="bg-white p-2 rounded-full text-green-500 shadow-sm mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">${namaSampah}</p>
                                <p class="text-xs text-gray-500">
                                    ${item.berat} ${uom} x Rp ${new Intl.NumberFormat('id-ID').format(hargaPerUnit)}
                                </p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-green-700">
                            Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}
                        </span>
                    </div>
                `;
                itemsContainer.innerHTML += itemHtml;
            });

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
