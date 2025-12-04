<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <div class="p-6 lg:p-10">
        
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <span class="inline-flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/></svg>
                        Dashboard Ketua
                    </span>
                </li>
            </ol>
        </nav>

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
                    <a href="{{ route('ketua.setoran.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                        + Input Setoran Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase">
                            <tr>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Nama Warga</th>
                                <th class="py-3 px-6 text-left">Total (Rp)</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($riwayatSetoran as $setoran)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->format('d M Y H:i') }}</td>
                                <td class="py-3 px-6 font-medium">{{ $setoran->warga->nama_lengkap }}</td>
                                <td class="py-3 px-6 text-green-600 font-bold">Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
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