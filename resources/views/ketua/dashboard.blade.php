<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h3 class="text-xl font-semibold">Halo, {{ Auth::user()->nama_lengkap }}!</h3>
                <p class="mt-1 text-gray-600">
                    Anda bertugas di <strong>Desa {{ Auth::user()->desa->nama_desa ?? '-' }}</strong>, RW <strong>{{ Auth::user()->rw }}</strong>.
                </p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Riwayat Input Setoran</h3>
                    
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase">
                            <tr>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Nama Warga</th>
                                <th class="py-3 px-6 text-left">Total</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($riwayatSetoran as $setoran)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->format('d M Y') }}</td>
                                <td class="py-3 px-6 font-medium">{{ $setoran->warga->nama_lengkap }}</td>
                                <td class="py-3 px-6 text-green-600 font-bold">Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ route('ketua.setoran.show', $setoran->id_setor) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-400">Belum ada riwayat setoran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {!! $riwayatSetoran->links() !!}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>