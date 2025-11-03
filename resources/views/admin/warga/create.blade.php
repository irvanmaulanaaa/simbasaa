<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Warga Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.warga.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="nama">
                                <span>Nama Lengkap</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="nik">
                                <span>NIK</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required />
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" />
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="rt" :value="__('RT')" />
                                <x-text-input id="rt" class="block mt-1 w-full" type="text" name="rt" :value="old('rt')" />
                                <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rw" :value="__('RW')" />
                                <x-text-input id="rw" class="block mt-1 w-full" type="text" name="rw" :value="old('rw')" />
                                <x-input-error :messages="$errors->get('rw')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kab_kota" :value="__('Kabupaten/Kota')" />
                                <x-text-input id="kab_kota" class="block mt-1 w-full" type="text" name="kab_kota" :value="old('kab_kota')" />
                                <x-input-error :messages="$errors->get('kab_kota')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password">
                                <span>Password</span>
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>