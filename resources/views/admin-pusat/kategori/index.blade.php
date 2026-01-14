<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kategori Sampah') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div id="global-loader" 
        class="fixed inset-0 bg-white bg-opacity-90 z-[9999] flex flex-col items-center justify-center transition-opacity duration-300"
        style="display: none;">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-red-600 mb-4"></div>
        <p class="text-red-700 font-bold text-lg animate-pulse">Menghapus Data...</p>
    </div>

    <div class="py-6 px-4 sm:px-0" 
        x-data="{ 
            showModal: false, 
            isEdit: false, 
            modalTitle: '', 
            formAction: '', 
            kategoriNama: '', 
            kategoriId: '',
            submitting: false, 
            
            openCreateModal() {
                this.isEdit = false;
                this.modalTitle = 'Tambah Kategori Baru';
                this.formAction = '{{ route('admin-pusat.kategori-sampah.store') }}';
                this.kategoriNama = '';
                this.showModal = true;
                this.submitting = false;
                this.$nextTick(() => { this.$refs.inputNama.focus(); });
            },

            openEditModal(id, nama, url) {
                this.isEdit = true;
                this.modalTitle = 'Edit Kategori';
                this.formAction = url;
                this.kategoriId = id;
                this.kategoriNama = nama;
                this.showModal = true;
                this.submitting = false;
                this.$nextTick(() => { this.$refs.inputNama.focus(); });
            }
        }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-pusat.dashboard') }}"
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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Kategori Sampah</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                        
                        <button @click="openCreateModal()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition ease-in-out duration-150 shadow-md w-full md:w-auto justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Kategori
                        </button>

                        <form method="GET" action="{{ route('admin-pusat.kategori-sampah.index') }}"
                            class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 w-full md:w-auto"
                            x-data="{
                                search: '{{ request('search') }}',
                                submitForm() { $el.submit(); },
                                clearSearch() {
                                    this.search = '';
                                    setTimeout(() => { this.submitForm(); }, 100);
                                }
                            }">
                            
                            <select name="per_page" onchange="this.form.submit()"
                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm cursor-pointer md:w-32">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                            </select>

                            <div class="relative w-full md:w-64">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" x-model="search"
                                    class="block w-full p-2 pl-10 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Cari kategori...">
                                <button type="button" @click="clearSearch()" x-show="search.length > 0"
                                    style="display: none;"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 focus:outline-none transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
                        <table class="min-w-full bg-white whitespace-nowrap">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-center w-12">No</th>
                                    <th class="py-3 px-6 text-left">Nama Kategori</th>
                                    <th class="py-3 px-6 text-center w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($kategoris as $kategori)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-6 text-center font-medium">
                                            {{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="font-bold text-gray-900">{{ $kategori->nama_kategori }}</div>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center space-x-2">
                                                
                                                <button @click="openEditModal({{ $kategori->id_kategori }}, '{{ $kategori->nama_kategori }}', '{{ route('admin-pusat.kategori-sampah.update', $kategori->id_kategori) }}')"
                                                    class="w-8 h-8 rounded bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition"
                                                    title="Edit Kategori">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                    </svg>
                                                </button>

                                                <button type="button"
                                                    onclick="confirmDeleteKategori({{ $kategori->id_kategori }}, '{{ $kategori->nama_kategori }}')"
                                                    class="w-8 h-8 rounded bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition"
                                                    title="Hapus Kategori">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>

                                                <form id="delete-form-{{ $kategori->id_kategori }}"
                                                    action="{{ route('admin-pusat.kategori-sampah.destroy', $kategori->id_kategori) }}"
                                                    method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-8 text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                <p>Data kategori belum tersedia.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $kategoris->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                    
                    <div x-show="submitting"
                        class="absolute inset-0 bg-white bg-opacity-90 z-50 flex flex-col items-center justify-center rounded-lg"
                        style="display: none;">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-green-600 mb-4"></div>
                        <p class="text-green-700 font-bold text-lg animate-pulse">Menyimpan Data...</p>
                    </div>

                    <form :action="formAction" method="POST" @submit="submitting = true">
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="modalTitle"></h3>
                            
                            <div class="mt-4">
                                <label for="nama_kategori" class="block text-sm font-medium text-gray-700">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_kategori" id="nama_kategori" 
                                    x-model="kategoriNama" x-ref="inputNama"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Contoh: Plastik, Kertas, Logam" required>
                                
                                @error('nama_kategori')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                :disabled="submitting"
                                :class="{ 'opacity-50 cursor-not-allowed': submitting }"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                                <span x-text="submitting ? 'Menyimpan...' : 'Simpan'"></span>
                            </button>
                            <button type="button" @click="showModal = false"
                                :disabled="submitting"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition ease-in-out duration-150">
                                Batal
                            </button>
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

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
            });
        @endif

        @if ($errors->any())
            document.addEventListener('alpine:init', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon periksa inputan Anda.',
                    confirmButtonText: 'Oke'
                });
            });
        @endif

        function confirmDeleteKategori(id, nama) {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Anda akan menghapus kategori '" + nama + "'. Pastikan tidak ada data sampah yang menggunakan kategori ini!",
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
