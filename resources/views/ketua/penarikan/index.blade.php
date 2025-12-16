<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase">
                            <tr>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-left">Nama Warga</th>
                                <th class="py-3 px-6 text-left">Jumlah</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($penarikans as $tarik)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6">{{ \Carbon\Carbon::parse($tarik->tgl_request)->format('d M Y H:i') }}</td>
                                <td class="py-3 px-6 font-medium">{{ $tarik->warga->nama_lengkap }}</td>
                                <td class="py-3 px-6 text-red-600 font-bold">Rp {{ number_format($tarik->jumlah, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        <form action="{{ route('ketua.penarikan.konfirmasi', $tarik->id_tarik) }}" method="POST" onsubmit="return confirm('Setujui penarikan ini? Saldo warga akan berkurang.');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('ketua.penarikan.konfirmasi', $tarik->id_tarik) }}" method="POST" onsubmit="return confirm('Tolak penarikan ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-400">Tidak ada permintaan penarikan pending.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {!! $penarikans->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>