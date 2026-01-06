<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-data.dashboard') }}"
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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Manajemen Pengguna</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin-data.users.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Tambah Pengguna
                    </a>

                    @if ($message = Session::get('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div x-data="{
                        showResetModal: false,
                        resetActionUrl: '',
                        userName: '',
                        openModal(url, name) {
                            this.resetActionUrl = url;
                            this.userName = name;
                            this.showResetModal = true;
                        }
                    }">

                        <div class="overflow-x-auto rounded-md">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">Nama</th>
                                        <th class="py-3 px-6 text-left">Username</th>
                                        <th class="py-3 px-6 text-left">Role</th>
                                        <th class="py-3 px-6 text-left">Lokasi</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @forelse ($users as $user)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left">{{ $user->nama_lengkap }}</td>
                                            <td class="py-3 px-6 text-left">{{ $user->username }}</td>
                                            <td class="py-3 px-6 text-left">{{ $user->role->nama_role }}</td>
                                            <td class="py-3 px-6 text-left">
                                                {{ $user->desa->nama_desa ?? '-' }},
                                                {{ $user->desa->kecamatan->nama_kecamatan ?? '' }}
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center items-center">

                                                    <a href="{{ route('admin-data.users.edit', $user->id_user) }}"
                                                        class="w-6 mr-4 transform hover:scale-110 text-indigo-600 hover:text-indigo-900"
                                                        title="Edit User">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                        </svg>
                                                    </a>

                                                    <button type="button"
                                                        @click="openModal('{{ route('admin-data.users.reset_password', $user->id_user) }}', '{{ $user->nama_lengkap }}')"
                                                        class="mr-4 transform hover:scale-105 px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold rounded shadow flex items-center gap-1"
                                                        title="Reset Password Custom">
                                                        
                                                        Reset
                                                    </button>

                                                    <form
                                                        action="{{ route('admin-data.users.destroy', $user->id_user) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan user ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="w-6 transform hover:scale-110 text-red-600 hover:text-red-900 cursor-pointer"
                                                            title="Hapus User">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Data masih kosong.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div x-show="showResetModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
                            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                @click="showResetModal = false"></div>

                            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                                <div
                                    class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full">

                                    <form :action="resetActionUrl" method="POST">
                                        @csrf
                                        @method('PUT')

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
                                                        <p class="text-sm text-gray-500 mb-4">
                                                            Masukkan password baru untuk user: <span
                                                                class="font-bold text-gray-800"
                                                                x-text="userName"></span>
                                                        </p>

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
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                                                Reset Password
                                            </button>
                                            <button type="button" @click="showResetModal = false"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                                Batal
                                            </button>
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
</x-app-layout>
