<x-app-layout>
    <x-slot name="sidebar">
        @include('warga.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Warga') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white rounded-2xl shadow-lg p-6  mb-8 text-lg">
            <p class="font-medium mb-1 text-black">Total Tabungan Anda</p>
            <h2 class="mt-2 text-4xl font-bold mb-6 text-green-600">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
            
            <div class="flex space-x-3 ">
                <a href="{{ route('warga.tarik.create') }}" class="bg-white text-green-700 px-4 py-2 rounded-lg font-bold text-sm hover:bg-green-50 transition shadow-sm">
                    Tarik Saldo
                </a>
            </div>
        </div>

        <h3 class="mt-5 text-xl font-semibold text-gray-800 mb-4">Riwayat Transaksi</h3>
        
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
            @if($riwayat->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($riwayat as $item)
                        <li class="p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-full {{ $item->tipe == 'setor' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        @if($item->tipe == 'setor')
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-bold text-gray-900 uppercase">
                                            {{ $item->tipe == 'setor' ? 'Setoran Sampah' : 'Penarikan Saldo' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold {{ $item->tipe == 'setor' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->tipe == 'setor' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </p>
                                    @if($item->tipe == 'tarik')
                                        <span class="text-xs px-2 py-0.5 rounded {{ $item->status == 'disetujui' ? 'bg-green-100 text-green-800' : ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>Belum ada riwayat transaksi.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>