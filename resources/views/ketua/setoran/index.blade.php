<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setoran Warga') }}
        </h2>
    </x-slot>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div id="global-loader"
        class="fixed inset-0 bg-white bg-opacity-90 z-[9999] flex flex-col items-center justify-center transition-opacity duration-300"
        style="display: none;">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
        <p class="text-green-700 font-bold text-lg animate-pulse">Loading...</p>
    </div>

    <div class="py-6 px-4 sm:px-0 min-h-screen" x-data="setoranHandler()">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Setoran Warga</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div
                        class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-6 space-y-4 xl:space-y-0">

                        <div class="flex-shrink-0">
                            <button @click="openFormModal()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-700 focus:outline-none focus:ring ring-green-300 transition ease-in-out duration-150 shadow-md h-[38px]">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Input Setoran
                            </button>
                        </div>

                        <form method="GET" action="{{ route('ketua.setoran.index') }}"
                            class="flex flex-col xl:flex-row space-y-4 xl:space-y-0 xl:space-x-4 w-full xl:w-auto items-end">

                            <div class="w-full md:w-auto">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Tampilkan</label>
                                <select name="per_page" onchange="this.form.submit()"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm cursor-pointer w-full md:w-32 h-[38px]">
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

                            <div class="w-full md:w-auto flex-grow" x-data="{ searchQuery: '{{ request('search') }}' }">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Cari Nama</label>
                                <div class="relative w-full md:w-64"> 
                                    <input type="text" name="search" x-model="searchQuery"
                                        placeholder="Nama warga..."
                                        class="w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm pl-3 pr-8 h-[38px]">

                                    <button type="button" x-show="searchQuery && searchQuery.length > 0"
                                        @click="searchQuery = ''; $nextTick(() => { $el.closest('form').submit(); });"
                                        class="absolute inset-y-0 right-0 flex items-center pr-2 text-gray-400 hover:text-red-500 transition cursor-pointer focus:outline-none"
                                        style="display: none;" x-transition>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div
                                class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 w-full md:w-auto items-end">

                                <div class="w-full md:w-auto">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm w-full md:w-auto h-[38px]">
                                </div>

                                <div class="w-full md:w-auto">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm w-full md:w-auto h-[38px]">
                                </div>

                                <div class="flex space-x-2 w-full md:w-auto">
                                    <button type="submit"
                                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition h-[38px] text-sm font-medium shadow-sm flex items-center justify-center flex-grow md:flex-grow-0">
                                        Filter
                                    </button>

                                    @if (request('start_date') || request('end_date'))
                                        <a href="{{ route('ketua.setoran.index', ['per_page' => request('per_page'), 'search' => request('search')]) }}"
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition h-[38px] flex items-center justify-center shadow-sm"
                                            title="Reset Tanggal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-center w-12">No</th>
                                    <th class="py-3 px-6 text-left whitespace-nowrap">Tanggal Transaksi</th>
                                    <th class="py-3 px-6 text-left whitespace-nowrap">Nama Warga</th>
                                    <th class="py-3 px-6 text-center whitespace-nowrap">Total Setoran</th>
                                    <th class="py-3 px-6 text-center whitespace-nowrap">Total Pendapatan</th>
                                    <th class="py-3 px-6 text-center w-24 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($setorans as $index => $setoran)
                                    <tr
                                        class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 group">
                                        <td class="py-3 px-6 text-center font-medium align-middle">
                                            {{ $setorans->firstItem() + $index }}
                                        </td>
                                        <td class="py-3 px-6 text-left align-middle whitespace-nowrap">
                                            <span
                                                class="font-bold text-gray-800 block">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->translatedFormat('d M Y') }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-left align-middle whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span
                                                    class="font-medium text-gray-900">{{ $setoran->warga->nama_lengkap ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-center align-middle whitespace-nowrap">
                                            @php
                                                $summary = $setoran->detail
                                                    ->groupBy('sampah.UOM')
                                                    ->map(function ($row) {
                                                        return $row->sum('berat');
                                                    });
                                            @endphp
                                            <div class="flex flex-col items-center gap-1">
                                                @foreach ($summary as $uom => $total)
                                                    <span
                                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-blue-200">
                                                        {{ (float) $total }} {{ $uom }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td
                                            class="py-3 px-6 text-center align-middle whitespace-nowrap font-bold text-green-700">
                                            Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-6 text-center align-middle whitespace-nowrap">
                                            <div class="flex item-center justify-center space-x-2">
                                                <button @click="openDetailModal({{ $setoran->id_setor }})"
                                                    class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm"
                                                    title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button @click="openFormModal({{ $setoran->id_setor }})"
                                                    class="w-8 h-8 rounded bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition shadow-sm"
                                                    title="Edit Data">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12 text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                    </path>
                                                </svg>
                                                <p class="text-base">Belum ada riwayat setoran.</p>
                                                <p class="text-xs mt-1">Silakan input setoran pertama Anda.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $setorans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showFormModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
                @click="showFormModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden transform transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                    <div class="bg-green-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <span x-text="isEdit ? 'Edit Data Setoran' : 'Input Setoran Baru'"></span>
                        </h3>
                        <button @click="showFormModal = false" class="text-green-100 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form :action="formAction" method="POST" class="p-6" @submit.prevent="validateAndSubmit"
                        novalidate>
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pilih Warga Penyetor <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="warga_id" x-model="formData.warga_id"
                                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm cursor-pointer transition-colors"
                                    :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': errors.warga_id }">
                                    <option value="">Pilih Nama Warga</option>
                                    @foreach ($wargas as $w)
                                        <option value="{{ $w->id_user }}">{{ $w->nama_lengkap }} (RW
                                            {{ $w->rw }})</option>
                                    @endforeach
                                </select>
                                <p x-show="errors.warga_id" class="text-red-500 text-xs mt-1"
                                    x-text="errors.warga_id"></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-6"
                            :class="{ 'border-red-300 bg-red-50': errors.items_empty }">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-bold text-sm text-gray-700">Rincian Item Sampah <span
                                        class="text-red-500">*</span></h4>
                                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border border-gray-200"
                                    x-text="items.length + ' Item'"></span>
                            </div>

                            <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                <template x-for="(item, index) in items" :key="index">
                                    <div
                                        class="grid grid-cols-12 gap-3 items-end bg-white p-3 rounded-lg shadow-sm border border-gray-100">

                                        <div class="col-span-12 md:col-span-5">
                                            <label
                                                class="text-[10px] text-gray-400 uppercase font-bold mb-1 block">Jenis
                                                Sampah <span class="text-red-500">*</span></label>
                                            <select name="sampah_id[]" x-model="item.sampah_id"
                                                @change="updateHarga(index)"
                                                class="w-full text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 py-1.5 cursor-pointer"
                                                :class="{ 'border-red-500 bg-red-50': errors.items[index]?.sampah_id }">
                                                <option value="" data-harga="0">Pilih Jenis Sampah</option>
                                                @foreach ($sampahs as $s)
                                                    <option value="{{ $s->id_sampah }}"
                                                        data-harga="{{ $s->harga_anggota }}">{{ $s->nama_sampah }}
                                                        (Rp
                                                        {{ number_format($s->harga_anggota) }}/{{ $s->UOM }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p x-show="errors.items[index]?.sampah_id"
                                                class="text-red-500 text-[10px] mt-1">Wajib dipilih</p>
                                        </div>

                                        <div class="col-span-5 md:col-span-3">
                                            <label
                                                class="text-[10px] text-gray-400 uppercase font-bold mb-1 block">Total
                                                <span class="text-red-500">*</span></label>
                                            <input type="number" name="berat[]" x-model="item.berat"
                                                @input="updateHarga(index)" step="0.01" min="0"
                                                class="w-full text-sm border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 py-1.5"
                                                placeholder="0"
                                                :class="{ 'border-red-500 bg-red-50': errors.items[index]?.berat }"
                                                onkeydown="return event.keyCode !== 69 && event.keyCode !== 189">
                                            <p x-show="errors.items[index]?.berat"
                                                class="text-red-500 text-[10px] mt-1">Wajib diisi</p>
                                        </div>

                                        <div class="col-span-5 md:col-span-3 text-right">
                                            <label
                                                class="text-[10px] text-gray-400 uppercase font-bold mb-1 block">Subtotal</label>
                                            <div class="text-sm font-bold text-gray-800 bg-gray-50 py-1.5 px-2 rounded border border-gray-100 truncate"
                                                x-text="formatRupiah(item.subtotal)"></div>
                                        </div>

                                        <div class="col-span-2 md:col-span-1 flex justify-center pb-1">
                                            <button type="button" @click="removeItem(index)"
                                                class="text-red-400 hover:text-red-600 transition p-1 rounded-full hover:bg-red-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <button type="button" @click="addItem()"
                                class="mt-3 w-full py-2 border-2 border-dashed border-green-300 text-green-600 rounded-lg text-sm font-semibold hover:bg-green-50 hover:border-green-400 transition flex items-center justify-center"><svg
                                    class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg> Tambah Item Sampah</button>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-2">
                            <div class="flex items-center gap-3 bg-green-50 px-4 py-3 rounded-xl w-full md:w-auto">
                                <div class="p-2 bg-white rounded-full text-green-600 shadow-sm"><svg class="w-6 h-6"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg></div>
                                <div>
                                    <p class="text-xs text-green-600 font-medium uppercase">Total Harga</p>
                                    <p class="text-xl font-bold text-green-800"
                                        x-text="formatRupiah(totalKeseluruhan)"></p>
                                </div>
                            </div>
                            <div class="flex gap-3 w-full md:w-auto justify-end">
                                <button type="button" @click="showFormModal = false"
                                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition shadow-md"><span
                                        x-text="isEdit ? 'Update' : 'Simpan'"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showDetailModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
                @click="showDetailModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-0 overflow-hidden transform transition-all">
                    <div class="bg-green-600 px-6 py-5 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center">Detail Transaksi</h3>
                        <button @click="showDetailModal = false"
                            class="text-green-200 hover:text-white transition"><svg class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div
                                class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xl mr-4">
                                <span x-text="detailData.warga_nama.charAt(0)"></span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900" x-text="detailData.warga_nama"></h4>
                                <p class="text-sm text-gray-500 flex items-center"><svg class="w-4 h-4 mr-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg> <span x-text="detailData.tanggal"></span></p>
                            </div>
                        </div>
                        <div class="border border-gray-100 rounded-xl overflow-hidden mb-6">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-100">
                                    <tr>
                                        <th class="px-4 py-2">Item</th>
                                        <th class="px-4 py-2 text-center">Berat/Qty</th>
                                        <th class="px-4 py-2 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="d in detailData.items">
                                        <tr>
                                            <td class="px-4 py-2 text-gray-700 font-medium" x-text="d.nama_sampah">
                                            </td>
                                            <td class="px-4 py-2 text-center text-gray-500"
                                                x-text="d.berat + ' ' + d.uom"></td>
                                            <td class="px-4 py-2 text-right font-bold text-gray-800"
                                                x-text="formatRupiah(d.subtotal)"></td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot class="bg-green-50">
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 font-bold text-green-800">TOTAL PENDAPATAN
                                        </td>
                                        <td class="px-4 py-3 text-right font-extrabold text-green-800 text-lg"
                                            x-text="formatRupiah(detailData.total_harga)"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function setoranHandler() {
            return {
                showFormModal: false,
                showDetailModal: false,
                isEdit: false,
                formAction: '',
                formData: {
                    warga_id: ''
                },
                items: [],
                totalKeseluruhan: 0,
                detailData: {
                    warga_nama: '',
                    tanggal: '',
                    total_berat: 0,
                    total_harga: 0,
                    items: []
                },
                masterSampah: @json($sampahs),

                errors: {
                    warga_id: null,
                    items: {},
                    items_empty: false
                },

                validateAndSubmit(e) {
                    this.errors = {
                        warga_id: null,
                        items: {},
                        items_empty: false
                    };
                    let isValid = true;

                    if (!this.formData.warga_id) {
                        this.errors.warga_id = 'Silakan pilih nama warga terlebih dahulu.';
                        isValid = false;
                    }

                    if (this.items.length === 0) {
                        this.errors.items_empty = true;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Daftar Kosong!',
                            text: 'Minimal input satu setoran sampah.',
                            confirmButtonColor: '#16a34a'
                        });
                        return;
                    }

                    this.items.forEach((item, index) => {
                        this.errors.items[index] = {};
                        if (!item.sampah_id) {
                            this.errors.items[index].sampah_id = true;
                            isValid = false;
                        }
                        if (!item.berat || item.berat <= 0) {
                            this.errors.items[index].berat = true;
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap',
                            text: 'Mohon lengkapi data yang berwarna merah.',
                            confirmButtonColor: '#dc2626'
                        });
                        return;
                    }

                    document.getElementById('global-loader').style.display = 'flex';
                    e.target.submit();
                },

                openFormModal(id = null) {
                    this.showFormModal = true;
                    this.isEdit = !!id;
                    this.items = [];
                    this.errors = {
                        warga_id: null,
                        items: {},
                        items_empty: false
                    };

                    if (this.isEdit) {
                        this.formAction = `/ketua/setoran/${id}`;
                        fetch(`/ketua/setoran/${id}`)
                            .then(res => res.json())
                            .then(data => {
                                this.formData.warga_id = data.warga_id;
                                this.items = data.detail.map(d => ({
                                    sampah_id: d.sampah_id,
                                    berat: parseFloat(d.berat),
                                    subtotal: d.subtotal,
                                    harga_per_kg: this.masterSampah.find(s => s.id_sampah == d.sampah_id)
                                        ?.harga_anggota || 0
                                }));
                                this.calculateTotal();
                            });
                    } else {
                        this.formAction = "{{ route('ketua.setoran.store') }}";
                        this.formData.warga_id = '';
                        this.addItem();
                        this.calculateTotal();
                    }
                },

                openDetailModal(id) {
                    fetch(`/ketua/setoran/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            this.detailData = {
                                warga_nama: data.warga ? data.warga.nama_lengkap : 'Unknown',
                                tanggal: new Date(data.tgl_setor).toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }),
                                total_harga: data.total_harga,
                                total_berat: data.detail.reduce((sum, item) => sum + parseFloat(item.berat), 0)
                                    .toFixed(2),
                                items: data.detail.map(d => ({
                                    nama_sampah: d.sampah ? d.sampah.nama_sampah : '-',
                                    berat: d.berat,
                                    uom: d.sampah ? d.sampah.UOM : 'Kg',
                                    subtotal: d.subtotal
                                }))
                            };
                            this.showDetailModal = true;
                        });
                },

                addItem() {
                    this.items.push({
                        sampah_id: '',
                        berat: '',
                        subtotal: 0,
                        harga_per_kg: 0
                    });
                    this.errors.items_empty = false;
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                    delete this.errors.items[index];
                    this.calculateTotal();
                },

                updateHarga(index) {
                    let item = this.items[index];

                    if (item.berat < 0) {
                        item.berat = 0;
                    }

                    let selectedSampah = this.masterSampah.find(s => s.id_sampah == item.sampah_id);
                    if (selectedSampah) {
                        item.harga_per_kg = selectedSampah.harga_anggota;
                    }

                    let berat = parseFloat(item.berat);
                    if (isNaN(berat)) berat = 0;

                    item.subtotal = berat * item.harga_per_kg;
                    this.calculateTotal();
                },

                calculateTotal() {
                    this.totalKeseluruhan = this.items.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0);
                },

                formatRupiah(number) {
                    if (isNaN(number)) return 'Rp 0';
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                }
            }
        }

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
    </script>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
            Maulana.</p>
    </footer>

</x-app-layout>
