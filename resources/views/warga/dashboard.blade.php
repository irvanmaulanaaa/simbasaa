<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-500">Total Tabungan Anda</h3>
                    <p class="mt-1 text-4xl font-semibold text-green-600">
                        Rp {{ number_format($totalTabungan, 0, ',', '.') }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('warga.tarik.create') }}"
                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tarik Saldo
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">Riwayat Transaksi Terakhir</h3>
                    <div class="overflow-x-auto rounded mb-4">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left">Tanggal</th>
                                    <th class="py-3 px-6 text-left">Tipe</th>
                                    <th class="py-3 px-6 text-left">Jumlah</th>
                                    <th class="py-3 px-6 text-center">Status</th> 
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($riwayatTransaksi as $item)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left">
                                            {{ \Carbon\Carbon::parse($item->tgl_transaksi)->format('d F Y') }}</td>
                                        <td class="py-3 px-6 text-left">
                                            @if ($item->tipe == 'setor')
                                                <span
                                                    class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Setor</span>
                                            @else
                                                <span
                                                    class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Tarik</span>
                                            @endif
                                        </td>
                                        <td
                                            class="py-3 px-6 text-left font-medium {{ $item->tipe == 'setor' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item->tipe == 'setor' ? '+' : '-' }} Rp
                                            {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>
                                        {{-- Data Status Baru --}}
                                        <td class="py-3 px-6 text-center">
                                            @if ($item->status == 'approved')
                                                <span
                                                    class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Disetujui</span>
                                            @elseif($item->status == 'pending')
                                                <span
                                                    class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">Pending</span>
                                            @elseif($item->status == 'rejected')
                                                <span
                                                    class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Anda belum memiliki riwayat
                                            transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $riwayatTransaksi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
