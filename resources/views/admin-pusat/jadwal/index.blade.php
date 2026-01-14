<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Penimbangan') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .flatpickr-calendar {
            width: 240px !important;
            padding: 5px !important;
            border-radius: 12px !important;
            background: #fff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            z-index: 99999 !important;
        }

        .flatpickr-time {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            max-height: none !important;
            padding: 10px 0 !important;
            border: none !important;
        }

        .flatpickr-time input.flatpickr-hour,
        .flatpickr-time input.flatpickr-minute {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            background: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            height: 50px !important;
            width: 65px !important;
        }

        .flatpickr-time .flatpickr-time-separator {
            font-size: 24px !important;
            font-weight: bold;
            color: #94a3b8 !important;
            width: 15px !important;
        }

        .flatpickr-am-pm,
        .numInputWrapper span {
            display: none !important;
        }

        .flatpickr-time input:focus {
            background: #fff !important;
            border-color: #3b82f6 !important;
        }

        @media (max-width: 640px) {
            .flatpickr-calendar {
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                position: fixed !important;
                width: 85% !important;
                max-width: 300px !important;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.2) !important;
            }

            .flatpickr-calendar::before,
            .flatpickr-calendar::after {
                display: none !important;
            }
        }
    </style>

    <div id="global-loader"
        class="fixed inset-0 bg-white bg-opacity-90 z-[9999] flex flex-col items-center justify-center transition-opacity duration-300"
        style="display: none;">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
        <p class="text-green-700 font-bold text-lg animate-pulse">Loading...</p>
    </div>

    <div class="py-6 px-4 sm:px-0" x-data="{
        showModal: false,
        isEdit: false,
        modalTitle: 'Tambah Jadwal Baru',
        formAction: '{{ route('admin-pusat.jadwal.store') }}',
        form: { tgl_jadwal: '', jam_penimbangan: '', kecamatan_id: '', desa_id: '', rw_penimbangan: '' },
        desaList: [],
        rwList: [],
        loadingDesa: false,
        loadingRW: false,
        errors: {},
    
        resetForm() {
            this.form = { tgl_jadwal: '', jam_penimbangan: '', kecamatan_id: '', desa_id: '', rw_penimbangan: '' };
            this.desaList = [];
            this.rwList = [];
            this.errors = {};
            this.isEdit = false;
            this.modalTitle = 'Tambah Jadwal Baru';
            this.formAction = '{{ route('admin-pusat.jadwal.store') }}';
        },
        openCreateModal() { this.resetForm();
            this.showModal = true; },
        async openEditModal(data, updateUrl) {
            this.resetForm();
            this.isEdit = true;
            this.modalTitle = 'Edit Jadwal Penimbangan';
            this.formAction = updateUrl;
            this.form.tgl_jadwal = data.tgl_jadwal;
            this.form.jam_penimbangan = data.jam_penimbangan.substring(0, 5);
            this.form.kecamatan_id = data.desa.kecamatan_id;
            await this.fetchDesa(false);
            this.form.desa_id = data.desa_id;
            await this.fetchRW(false);
            this.form.rw_penimbangan = data.rw_penimbangan;
            this.showModal = true;
        },
        async fetchDesa(resetChild = true) {
            if (resetChild) { this.form.desa_id = '';
                this.form.rw_penimbangan = '';
                this.rwList = []; }
            if (!this.form.kecamatan_id) return;
            this.loadingDesa = true;
            try { let res = await fetch('/admin-pusat/api/desas/' + this.form.kecamatan_id);
                this.desaList = await res.json(); } catch (e) { console.error(e); }
            this.loadingDesa = false;
        },
        async fetchRW(resetChild = true) {
            if (resetChild) { this.form.rw_penimbangan = ''; }
            if (!this.form.desa_id) return;
            this.loadingRW = true;
            try { let res = await fetch('/admin-pusat/api/rws/' + this.form.desa_id);
                this.rwList = await res.json(); } catch (e) { console.error(e); }
            this.loadingRW = false;
        },
        validate() {
            this.errors = {};
            if (!this.form.tgl_jadwal) this.errors.tgl = 'Tanggal wajib diisi';
            if (!this.form.jam_penimbangan) { this.errors.jam = 'Jam wajib diisi'; } else { const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/; if (!timeRegex.test(this.form.jam_penimbangan)) { this.errors.jam = 'Format waktu tidak valid (00:00 - 23:59)'; } }
            if (!this.form.kecamatan_id) this.errors.kec = 'Wajib dipilih';
            if (!this.form.desa_id) this.errors.desa = 'Wajib dipilih';
            if (!this.form.rw_penimbangan) this.errors.rw = 'Wajib dipilih';
            return Object.keys(this.errors).length === 0;
        },
        submitForm(e) {
            if (!this.validate()) { e.preventDefault(); return; }
            document.getElementById('global-loader').style.display = 'flex';
        }
    }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center"><a href="{{ route('admin-pusat.dashboard') }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">Home</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Jadwal Penimbangan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div
                        class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
                        <button @click="openCreateModal()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition ease-in-out duration-150 shadow-md h-[38px]"><svg
                                class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>Buat Jadwal</button>
                        <form method="GET" action="{{ route('admin-pusat.jadwal.index') }}"
                            class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 w-full xl:w-auto items-end">
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
                                </select>
                            </div>
                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 w-full md:w-auto">
                                <div class="w-full md:w-auto"><label
                                        class="block text-xs font-medium text-gray-500 mb-1">Dari</label><input
                                        type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm w-full md:w-auto h-[38px]">
                                </div>
                                <div class="w-full md:w-auto"><label
                                        class="block text-xs font-medium text-gray-500 mb-1">Sampai</label>
                                    <div class="flex space-x-2"><input type="date" name="end_date"
                                            value="{{ request('end_date') }}"
                                            class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm w-full md:w-auto h-[38px]"><button
                                            type="submit"
                                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition h-[38px] text-sm font-medium shadow-sm flex items-center">
                                            <svg
                                                class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg> Cari</button>
                                        @if (request('start_date') || request('end_date'))
                                            <a href="{{ route('admin-pusat.jadwal.index') }}"
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition h-[38px] flex items-center shadow-sm"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-center w-12">No</th>
                                    <th class="py-3 px-6 text-left whitespace-nowrap">Hari, Tanggal</th>
                                    <th class="py-3 px-6 text-left whitespace-nowrap">Jam</th>
                                    <th class="py-3 px-6 text-left">Lokasi</th>
                                    <th class="py-3 px-6 text-left whitespace-nowrap">Status</th>
                                    <th class="py-3 px-6 text-center w-32 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($jadwals as $jadwal)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-6 text-center font-medium align-middle">
                                            {{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="py-3 px-6 text-left align-middle whitespace-nowrap"><span
                                                class="font-bold text-gray-800 block">{{ \Carbon\Carbon::parse($jadwal->tgl_jadwal)->translatedFormat('l, d M Y') }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-left align-middle whitespace-nowrap"><span
                                                class="font-bold text-gray-800 block">{{ \Carbon\Carbon::parse($jadwal->jam_penimbangan)->format('H:i') }}
                                                WIB</span></td>

                                        <td class="py-3 px-6 text-left align-middle">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-800 text-sm">
                                                    RW {{ $jadwal->rw_penimbangan }}, Desa
                                                    {{ $jadwal->desa->nama_desa }}
                                                </span>

                                                <span class="text-xs text-gray-600 mt-0.5">
                                                    Kec. {{ $jadwal->desa->kecamatan->nama_kecamatan ?? '-' }}
                                                </span>

                                                <span class="text-xs text-gray-600">
                                                    {{ $jadwal->desa->kecamatan->kabKota->nama_kab_kota ?? 'Kab. Bandung' }},
                                                    {{ $jadwal->desa->kecamatan->kabKota->provinsi->nama_provinsi ?? 'Jawa Barat' }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="py-3 px-6 text-left align-middle whitespace-nowrap">
                                            @php
                                                $tgl = \Carbon\Carbon::parse($jadwal->tgl_jadwal);
                                                $isToday = $tgl->isToday();
                                                $isPast = $tgl->isPast() && !$isToday;
                                            @endphp
                                            @if ($isToday)
                                                <span
                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-green-200"><span
                                                        class="w-2 h-2 mr-1 bg-green-500 rounded-full animate-pulse"></span>Hari
                                                    Ini</span>
                                            @elseif ($isPast)
                                                <span
                                                    class="bg-blue-100 text-gray-600 text-xs font-bold px-2.5 py-0.5 rounded-full border border-blue-200">Selesai</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded-full border border-yellow-200">Akan
                                                    Datang</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center align-middle whitespace-nowrap">
                                            <div class="flex item-center justify-center space-x-2">
                                                <button
                                                    @click="openEditModal({{ $jadwal->toJson() }}, '{{ route('admin-pusat.jadwal.update', $jadwal->id_jadwal) }}')"
                                                    class="w-8 h-8 rounded bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition shadow-sm"><svg
                                                        class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                    </svg></button>
                                                <button type="button"
                                                    onclick="confirmDelete({{ $jadwal->id_jadwal }})"
                                                    class="w-8 h-8 rounded bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm"><svg
                                                        class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg></button>
                                                <form id="delete-form-{{ $jadwal->id_jadwal }}"
                                                    action="{{ route('admin-pusat.jadwal.destroy', $jadwal->id_jadwal) }}"
                                                    method="POST" class="hidden">@csrf @method('DELETE')</form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty <tr>
                                        <td colspan="6" class="text-center py-12 text-gray-500">Data Kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $jadwals->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
                @click="showModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-xl shadow-2xl transform transition-all sm:max-w-lg w-full overflow-hidden"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                    <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white"><span
                                x-text="isEdit ? 'Edit Jadwal' : 'Jadwal Baru'"></span></h3>
                        <button @click="showModal = false" class="text-blue-200 hover:text-white transition"><svg
                                class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <form :action="formAction" method="POST" @submit="submitForm" novalidate>
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                        <div class="p-6 space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tgl_jadwal" x-model="form.tgl_jadwal"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                        :class="{ 'border-red-500': errors.tgl }">
                                    <p x-show="errors.tgl" class="text-red-500 text-xs mt-1" x-text="errors.tgl"></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span
                                            class="text-red-500">*</span></label>

                                    <div class="relative">
                                        <input type="text" name="jam_penimbangan" x-model="form.jam_penimbangan"
                                            x-init="flatpickr($el, {
                                                enableTime: true,
                                                noCalendar: true,
                                                dateFormat: 'H:i',
                                                time_24hr: true,
                                                minTime: '00:00', // BATAS JAM
                                                maxTime: '23:59',
                                                disableMobile: true,
                                                static: false
                                            })" placeholder="Pilih Jam"
                                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm cursor-pointer bg-white"
                                            :class="{ 'border-red-500': errors.jam }" readonly>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-1">Format 24 Jam (Contoh: 14:00)</p>
                                    <p x-show="errors.jam" class="text-red-500 text-xs mt-1" x-text="errors.jam"></p>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan <span
                                        class="text-red-500">*</span></label>
                                <select name="kecamatan_id" x-model="form.kecamatan_id" @change="fetchDesa()"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm cursor-pointer"
                                    :class="{ 'border-red-500': errors.kec }">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatans as $kec)
                                        <option value="{{ $kec->id_kecamatan }}">{{ $kec->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                <p x-show="errors.kec" class="text-red-500 text-xs mt-1" x-text="errors.kec"></p>
                            </div>

                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Desa <span
                                        class="text-red-500">*</span></label>
                                <select name="desa_id" x-model="form.desa_id" @change="fetchRW()"
                                    :disabled="!form.kecamatan_id || loadingDesa"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm disabled:bg-gray-100 cursor-pointer"
                                    :class="{ 'border-red-500': errors.desa }">
                                    <option value="">-- Pilih Desa --</option>
                                    <template x-for="desa in desaList" :key="desa.id_desa">
                                        <option :value="desa.id_desa" x-text="desa.nama_desa"></option>
                                    </template>
                                </select>
                                <div x-show="loadingDesa" class="absolute right-3 top-9"><svg
                                        class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg></div>
                                <p x-show="errors.desa" class="text-red-500 text-xs mt-1" x-text="errors.desa"></p>
                            </div>

                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-1">RW <span
                                        class="text-red-500">*</span></label>
                                <select name="rw_penimbangan" x-model="form.rw_penimbangan"
                                    :disabled="!form.desa_id || loadingRW"
                                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm disabled:bg-gray-100 cursor-pointer"
                                    :class="{ 'border-red-500': errors.rw }">
                                    <option value="">-- Pilih RW --</option>
                                    <template x-for="item in rwList" :key="item.rw">
                                        <option :value="item.rw" x-text="'RW ' + item.rw"></option>
                                    </template>
                                </select>
                                <div x-show="loadingRW" class="absolute right-3 top-9"><svg
                                        class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg></div>
                                <p x-show="!loadingRW && form.desa_id && rwList.length === 0"
                                    class="text-[11px] text-red-500 mt-1 flex items-center"><svg class="w-3 h-3 mr-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> Belum ada RW terdaftar.</p>
                                <p x-show="errors.rw" class="text-red-500 text-xs mt-1" x-text="errors.rw"></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-xl">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"><span
                                    x-text="isEdit ? 'Update Jadwal' : 'Simpan Jadwal'"></span></button>
                        </div>
                    </form>
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
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Jadwal?',
                text: "Data akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('global-loader').style.display = 'flex';
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
