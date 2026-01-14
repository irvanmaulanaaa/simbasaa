<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Sampah') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0 min-h-screen">
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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Data Sampah</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                        <a href="{{ route('admin-pusat.sampah.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring ring-blue-300 transition ease-in-out duration-150 shadow-md w-full md:w-auto justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Sampah
                        </a>

                        <form method="GET" action="{{ route('admin-pusat.sampah.index') }}"
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
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Data</option>
                            </select>

                            <select name="kategori_id" onchange="this.form.submit()"
                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm md:w-40 cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}"
                                        {{ request('kategori_id') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="status" onchange="this.form.submit()"
                                class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm md:w-32 cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
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
                                    placeholder="Cari nama / kode...">
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
                                    <th class="py-3 px-3 sm:px-6 text-center w-12">No</th>
                                    <th class="py-3 px-3 sm:px-6 text-left">Kode</th>
                                    <th class="py-3 px-3 sm:px-6 text-left">Kode BSB</th>
                                    <th class="py-3 px-3 sm:px-6 text-left">Nama Sampah</th>
                                    <th class="py-3 px-3 sm:px-6 text-center">Kategori</th>
                                    <th class="py-3 px-3 sm:px-6 text-center">Satuan</th>
                                    <th class="py-3 px-3 sm:px-6 text-right">Harga Anggota</th>
                                    <th class="py-3 px-3 sm:px-6 text-right">Harga BSB</th>
                                    <th class="py-3 px-3 sm:px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($sampahs as $sampah)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-3 sm:px-6 text-center font-medium">
                                            {{ ($sampahs->currentPage() - 1) * $sampahs->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-left">
                                            <div class="font-bold text-gray-900">
                                                {{ $sampah->kode_sampah }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-left">
                                            @if($sampah->kode_bsb)
                                                <div class="font-bold text-gray-900">
                                                    {{ $sampah->kode_bsb }}
                                                </div>
                                            @else
                                                <span class="text-gray-300 text-xs italic">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-left">
                                            <div class="font-bold text-gray-900">{{ $sampah->nama_sampah }}</div>
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-center">
                                            @if ($sampah->kategori)
                                                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-md border border-indigo-200">
                                                    {{ $sampah->kategori->nama_kategori }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs italic">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-center font-bold">
                                            {{ strtoupper($sampah->UOM) }}
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-center font-bold text-green-600">
                                            Rp {{ number_format($sampah->harga_anggota, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-center font-medium text-blue-600">
                                            Rp {{ number_format($sampah->harga_bsb, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-3 sm:px-6 text-center">
                                            @if ($sampah->status_sampah == 'aktif')
                                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Aktif</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center space-x-2">
                                                
                                                <a href="{{ route('admin-pusat.sampah.edit', $sampah->id_sampah) }}"
                                                    class="w-8 h-8 rounded bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition"
                                                    title="Edit Data">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                    </svg>
                                                </a>

                                                @if ($sampah->status_sampah == 'aktif')
                                                    <button type="button"
                                                        onclick="confirmNonaktif({{ $sampah->id_sampah }}, '{{ $sampah->nama_sampah }}')"
                                                        class="w-8 h-8 rounded bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition"
                                                        title="Nonaktifkan Sampah">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>

                                                    <form id="delete-form-{{ $sampah->id_sampah }}"
                                                        action="{{ route('admin-pusat.sampah.destroy', $sampah->id_sampah) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-8 text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                <p>Data sampah belum tersedia.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $sampahs->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
        <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan Maulana.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        function confirmNonaktif(id, nama) {
            Swal.fire({
                title: 'Nonaktifkan Sampah?',
                text: "Sampah '" + nama + "' tidak akan muncul lagi di menu transaksi penimbangan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Nonaktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
