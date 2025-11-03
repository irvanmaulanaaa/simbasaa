<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi Penarikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.setoran.update', $setoran->id) }}">
                        @csrf
                        @method('PUT')
                        <p class="mb-2"><strong>Warga:</strong> {{ $setoran->user->nama }}</p>
                        <div class="mt-4">
                           <x-input-label for="jumlah" value="Jumlah Penarikan (Rp)" />
                           <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah', $setoran->jumlah)" required min="1000" />
                           <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">{{ __('Update Transaksi') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>