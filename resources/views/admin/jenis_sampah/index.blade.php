<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.jenis_sampah.create') }}"
                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        Tambah Sampah Baru
                    </a>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded mb-4">
                        <div class="bg-white shadow-md">
                            <div
                                class="flex justify-between bg-gray-200 text-gray-600 uppercase text-sm leading-normal font-bold">
                                <div class="py-3 px-6 w-1/12 text-left">No</div>
                                <div class="py-3 px-6 w-4/12 text-left">Nama Sampah</div>
                                <div class="py-3 px-6 w-3/12 text-left">Kategori</div>
                                <div class="py-3 px-6 w-2/12 text-left">Harga/Kg</div>
                                <div class="py-3 px-6 w-2/12 text-center">Aksi</div>
                            </div>

                            <div class="text-gray-600 text-sm font-light">
                                @forelse ($jenisSampah as $index => $item)
                                    <div
                                        class="flex justify-between items-center border-b border-gray-200 hover:bg-gray-100">
                                        <div class="py-3 px-6 w-1/12 text-left">{{ $index + $jenisSampah->firstItem() }}
                                        </div>
                                        <div class="py-3 px-6 w-4/12 text-left">{{ $item->nama }}</div>
                                        <div class="py-3 px-6 w-3/12 text-left">
                                            {{ $item->kategoriSampah->nama_kategori }}
                                        </div>
                                        <div class="py-3 px-6 w-2/12 text-left">Rp
                                            {{ number_format($item->harga_per_kg, 0, ',', '.') }}</div>
                                        <div class="py-3 px-6 w-2/12 text-center">
                                            <div class="flex item-center justify-center">
                                                <a href="{{ route('admin.jenis_sampah.show', $item->id) }}"
                                                    class="relative group w-4 mr-2 transform text-green-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span
                                                        class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-gray-700 rounded-md group-hover:block">Detail</span>
                                                </a>
                                                <a href="{{ route('admin.jenis_sampah.edit', $item->id) }}"
                                                    class="relative group w-4 mr-2 transform text-blue-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                                    </svg>
                                                    <span
                                                        class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-gray-700 rounded-md group-hover:block">Edit</span>
                                                </a>
                                                <form action="{{ route('admin.jenis_sampah.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                    class="relative group">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-4 mr-2 transform text-red-500 hover:scale-110 cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                    <span
                                                        class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-gray-700 rounded-md group-hover:block">Hapus</span>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        Belum ada data jenis sampah.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $jenisSampah->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
