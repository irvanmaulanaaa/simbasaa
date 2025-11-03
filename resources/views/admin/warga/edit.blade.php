<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.warga.update', $warga->id) }}">
                        @csrf
                        @method('PUT') {{-- Method untuk update --}}

                        <div>
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $warga->nama)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik', $warga->nik)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat', $warga->alamat)" />
                        </div>
                        
                        {{-- ... (Input untuk RT, RW, Kab/Kota) ... --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="rt" :value="__('RT')" />
                                <x-text-input id="rt" class="block mt-1 w-full" type="text" name="rt" :value="old('rt', $warga->rt)" />
                            </div>
                            <div>
                                <x-input-label for="rw" :value="__('RW')" />
                                <x-text-input id="rw" class="block mt-1 w-full" type="text" name="rw" :value="old('rw', $warga->rw)" />
                            </div>
                            <div>
                                <x-input-label for="kab_kota" :value="__('Kabupaten/Kota')" />
                                <x-text-input id="kab_kota" class="block mt-1 w-full" type="text" name="kab_kota" :value="old('kab_kota', $warga->kab_kota)" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>