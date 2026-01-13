<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kecamatan') }}
        </h2>
    </x-slot>

    <div class="flex flex-col min-h-screen bg-gray-100">

        <div class="flex-grow py-6 px-4 sm:px-0">
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
                                <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Manajemen Kecamatan</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                <strong class="font-bold">Whoops!</strong> Ada input yang salah.
                                <ul class="mt-1 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">

                            <button onclick="openCreateModal()"
                                class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-blue-700 transition shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Kecamatan
                            </button>

                            <form method="GET" action="{{ route('admin-data.kecamatan.index') }}"
                                class="flex flex-wrap md:flex-nowrap gap-2 w-full md:w-auto items-center justify-end"
                                x-data="{
                                    search: '{{ request('search') }}',
                                    submitForm() {
                                        $el.submit();
                                    },
                                    clearSearch() {
                                        this.search = '';
                                        setTimeout(() => { this.submitForm(); }, 100);
                                    }
                                }">

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

                                <div class="relative w-full md:w-64">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>

                                    <input type="text" name="search" x-model="search"
                                        class="block w-full p-2 pl-10 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Cari Kecamatan...">

                                    <button type="button" @click="clearSearch()" x-show="search.length > 0"
                                        style="display: none;"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 focus:outline-none transition"
                                        title="Hapus pencarian">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-center w-16">No</th>
                                        <th class="py-3 px-6 text-left">Nama Kecamatan</th>
                                        <th class="py-3 px-6 text-left">Kabupaten/Kota</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @forelse ($kecamatans as $kecamatan)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-6 text-center font-medium">
                                                {{ ($kecamatans->currentPage() - 1) * $kecamatans->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="py-3 px-6 text-left font-medium text-gray-900">
                                                {{ $kecamatan->nama_kecamatan }}
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <span
                                                    class=" text-gray-600 text-sm font-semibold">{{ $kecamatan->kab_kota }}</span>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center space-x-2">
                                                    <button
                                                        onclick="openEditModal('{{ route('admin-data.kecamatan.update', $kecamatan->id_kecamatan) }}', '{{ $kecamatan->nama_kecamatan }}')"
                                                        class="w-8 h-8 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition"
                                                        title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                        </svg>
                                                    </button>

                                                    <button
                                                        onclick="confirmDelete('{{ route('admin-data.kecamatan.destroy', $kecamatan->id_kecamatan) }}', '{{ $kecamatan->nama_kecamatan }}')"
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
                                            <td colspan="4" class="text-center py-8 text-gray-500">Data kecamatan
                                                tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">{{ $kecamatans->links() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan Maulana.</p>
        </footer>

    </div>
    <div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('createModal')">
        </div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form action="{{ route('admin-data.kecamatan.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Tambah Kecamatan</h3>
                                <div class="mt-4">
                                    <label for="nama_kecamatan"
                                        class="block text-sm font-medium text-gray-700 text-left">Nama
                                        Kecamatan</label>
                                    <input type="text" name="nama_kecamatan" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="Contoh: Bojongsoang">
                                    <p class="text-xs text-gray-500 mt-1 text-left">*Kabupaten otomatis diset:
                                        Kabupaten Bandung</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto">Simpan</button>
                        <button type="button" onclick="closeModal('createModal')"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-200 sm:mt-0 sm:w-auto">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('editModal')">
        </div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">Edit Nama Kecamatan</h3>
                                <div class="mt-4">
                                    <label for="edit_nama_kecamatan"
                                        class="block text-sm font-medium text-gray-700 text-left">Nama
                                        Kecamatan</label>
                                    <input type="text" id="edit_nama_kecamatan" name="nama_kecamatan" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto">Ubah</button>
                        <button type="button" onclick="closeModal('editModal')"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-200 sm:mt-0 sm:w-auto">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="delete-form" action="" method="POST" style="display: none;"> @csrf @method('DELETE') </form>
    <div id="loadingOverlay"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex-col items-center justify-center">
        <div class="bg-white p-6 rounded-2xl shadow-xl flex flex-col items-center">
            <div class="animate-spin rounded-full h-14 w-14 border-t-4 border-b-4 border-red-600 mb-4"></div>
            <p class="text-gray-800 font-bold">Loading...</p>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function openEditModal(url, nama) {
            document.getElementById('editForm').action = url;
            document.getElementById('edit_nama_kecamatan').value = nama;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
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

        function confirmDelete(url, name) {
            Swal.fire({
                title: 'Hapus Kecamatan?',
                text: "Hapus: " + name + "?",
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
