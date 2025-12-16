<x-app-layout>
    <x-slot name="sidebar">
        @include('warga.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="max-w-xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Masukkan nominal yang ingin Anda cairkan</h2>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-center">
                <p class="text-green-600 font-medium text-sm">Saldo Tersedia</p>
                <p class="text-3xl font-bold text-green-700">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('warga.tarik.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <x-input-label for="jumlah" :value="__('Nominal Penarikan')" />
                        <x-text-input id="jumlah" class="block mt-1 w-full text-lg font-semibold" 
                                      type="number" 
                                      name="jumlah" 
                                      placeholder="Contoh: 10000" 
                                      required autofocus />
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="keterangan" :value="__('Catatan (Opsional)')" />
                        <textarea name="keterangan" id="keterangan" rows="3"
                            class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                            placeholder="Misal: Keperluan sekolah"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('warga.dashboard') }}" class="text-gray-600 hover:text-gray-900 underline text-sm">Batal</a>
                        <x-primary-button>
                            {{ __('Ajukan Sekarang') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>