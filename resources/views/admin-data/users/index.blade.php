<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
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
                                <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Manajemen Pengguna</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">

                            <a href="{{ route('admin-data.users.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md w-full md:w-auto justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Pengguna
                            </a>

                            <form method="GET" action="{{ route('admin-data.users.index') }}"
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
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data
                                    </option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data
                                    </option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data
                                    </option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Data
                                    </option>
                                </select>

                                <select name="filter" onchange="this.form.submit()"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg text-sm shadow-sm md:w-48">
                                    <option value="">Semua</option>
                                    <optgroup label="Berdasarkan Role">
                                        @foreach ($roles as $role)
                                            <option value="role_{{ $role->id_role }}"
                                                {{ request('filter') == 'role_' . $role->id_role ? 'selected' : '' }}>
                                                {{ $role->nama_role }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Berdasarkan Status">
                                        <option value="status_aktif"
                                            {{ request('filter') == 'status_aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="status_tidak_aktif"
                                            {{ request('filter') == 'status_tidak_aktif' ? 'selected' : '' }}>Tidak
                                            Aktif</option>
                                    </optgroup>
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
                                        placeholder="Cari nama / username...">
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

                        <div x-data="{
                            showResetModal: false,
                            resetActionUrl: '',
                            resetUserName: '',
                            openResetModal(url, name) {
                                this.resetActionUrl = url;
                                this.resetUserName = name;
                                this.showResetModal = true;
                            },
                            showDeleteModal: false,
                            deleteActionUrl: '',
                            deleteUserName: '',
                            openDeleteModal(url, name) {
                                this.deleteActionUrl = url;
                                this.deleteUserName = name;
                                this.showDeleteModal = true;
                            }
                        }">

                            <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold leading-normal">
                                        <tr>
                                            <th class="py-3 px-6 text-center w-12">No</th>
                                            <th class="py-3 px-6 text-left">Nama Lengkap</th>
                                            <th class="py-3 px-6 text-left">Username</th>
                                            <th class="py-3 px-6 text-left">Role</th>
                                            <th class="py-3 px-6 text-left">No. Telepon</th>
                                            <th class="py-3 px-6 text-center">Status</th>
                                            <th class="py-3 px-6 text-left w-1/3">Alamat Lengkap</th>
                                            <th class="py-3 px-6 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @forelse ($users as $index => $user)
                                            <tr
                                                class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                                <td class="py-3 px-6 text-center font-medium">
                                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap text-black">
                                                    <div class="flex items-center"><span
                                                            class="font-medium">{{ $user->nama_lengkap }}</span></div>
                                                </td>
                                                <td class="py-3 px-6 text-left font-medium"><span
                                                        class="text-black">{{ $user->username }}</span></td>
                                                <td class="py-3 px-6 text-left font-bold text-black">
                                                    <span>{{ $user->role->nama_role }}</span>
                                                </td>
                                                <td class="py-3 px-6 text-left font-medium"><span
                                                        class="text-black whitespace-nowrap">{{ $user->no_telepon ?? '-' }}</span>
                                                </td>
                                                <td class="py-3 px-6 text-center">
                                                    @if ($user->status == 'aktif')
                                                        <span
                                                            class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide whitespace-nowrap">Aktif</span>
                                                    @else
                                                        <span
                                                            class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide whitespace-nowrap">Tidak
                                                            Aktif</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-6 text-left text-sm leading-relaxed text-black">
                                                    @if ($user->desa)
                                                        <p>{{ $user->jalan ?? '-' }}, RT.{{ $user->rt ?? '-' }} /
                                                            RW.{{ $user->rw ?? '-' }},</p>
                                                        <p class="mt-1">Desa {{ $user->desa->nama_desa }}, Kec.
                                                            {{ $user->desa->kecamatan->nama_kecamatan ?? '' }}</p>
                                                        <p class="mt-1">
                                                            {{ $user->desa->kecamatan->kab_kota ?? '' }}, Jawa Barat
                                                        </p>
                                                    @else
                                                        <span
                                                            class="bg-red-100 text-red-600 py-1 px-2 rounded text-xs">Alamat
                                                            belum lengkap</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-6 text-center">
                                                    <div class="flex item-center justify-center space-x-2">
                                                        <a href="{{ route('admin-data.users.edit', $user->id_user) }}"
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
                                                            @click="openResetModal('{{ route('admin-data.users.reset_password', $user->id_user) }}', '{{ $user->nama_lengkap }}')"
                                                            class="w-8 h-8 rounded bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition"
                                                            title="Reset Password">
                                                            <x-heroicon-o-arrow-path class="h-4 w-4" />
                                                        </button>
                                                        @if ($user->status == 'aktif')
                                                            <button type="button"
                                                                @click="openDeleteModal('{{ route('admin-data.users.destroy', $user->id_user) }}', '{{ $user->nama_lengkap }}')"
                                                                class="w-8 h-8 rounded bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition"
                                                                title="Nonaktifkan">
                                                                <svg class="w-4 h-4" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-8 text-gray-500">
                                                    <div
                                                        class="flex flex-col items-center justify-center text-gray-500">
                                                        <svg class="w-12 h-12 mb-2 text-gray-300" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                        <p>Data pengguna tidak ditemukan.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $users->links() }}
                            </div>

                            <div x-show="showResetModal" class="fixed inset-0 z-50 overflow-y-auto"
                                style="display: none;" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    @click="showResetModal = false"></div>
                                <div class="flex items-center justify-center min-h-screen p-4 text-center">
                                    <div
                                        class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full">
                                        <form :action="resetActionUrl" method="POST">
                                            @csrf @method('PUT')
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div
                                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-yellow-600" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Reset
                                                            Password User</h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500 mb-4">Masukkan password
                                                                baru untuk: <span class="font-bold text-gray-800"
                                                                    x-text="resetUserName"></span></p>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 mb-1">Password
                                                                Baru</label>
                                                            <input type="text" name="new_password" required
                                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                                                                placeholder="Contoh: 123456" minlength="6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Reset
                                                    Password</button>
                                                <button type="button" @click="showResetModal = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto"
                                style="display: none;" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    @click="showDeleteModal = false"></div>
                                <div class="flex items-center justify-center min-h-screen p-4 text-center">
                                    <div
                                        class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full">
                                        <form :action="deleteActionUrl" method="POST">
                                            @csrf @method('DELETE')
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div
                                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-red-600" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                            Nonaktifkan Pengguna</h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin
                                                                menonaktifkan pengguna <span
                                                                    class="font-bold text-gray-800"
                                                                    x-text="deleteUserName"></span>?</p>
                                                            <p class="text-sm text-red-500 mt-1">Pengguna tidak akan
                                                                bisa login lagi setelah dinonaktifkan.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Ya,
                                                    Nonaktifkan</button>
                                                <button type="button" @click="showDeleteModal = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-auto py-6 text-center text-sm text-gray-500 bg-gray-50 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-green-600">SIMBASA Developed by</span> Irvan
                Maulana. All
                rights reserved.</p>
        </footer>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</x-app-layout>
