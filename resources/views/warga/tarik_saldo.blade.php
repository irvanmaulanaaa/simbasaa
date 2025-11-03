<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penarikan Saldo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700">
                        <p class="font-bold">Saldo Tersedia</p>
                        <p class="text-2xl">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                    </div>

                    <form method="POST" action="{{ route('warga.tarik.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="jumlah">
                                <span>Jumlah Penarikan (Minimal Rp 10.000)</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah')" required min="10000" />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Kirim Permintaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>