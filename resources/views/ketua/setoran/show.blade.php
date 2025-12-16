<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Setoran Sampah') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Transaksi</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Warga:</p>
                    <p class="font-semibold">{{ $setoran->warga->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal Setor:</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($setoran->tgl_setor)->format('d M Y') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-500">Dicatat Oleh:</p>
                    <p class="font-semibold">{{ $setoran->ketua->nama_lengkap ?? 'Admin Pusat' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Rincian Sampah</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Sampah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat / UOM</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Anggota</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($setoran->detail as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail->sampah->nama_sampah }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($detail->berat, 2) }} {{ $detail->sampah->UOM }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">Rp {{ number_format($detail->sampah->harga_anggota, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-left text-md font-bold text-gray-900">TOTAL SETORAN</td>
                                <td class="px-6 py-4 text-right text-lg font-extrabold text-green-700">Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>