<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil, alamat, dan foto Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_photo" :value="__('Foto Profil')" />
            <div class="mt-2 flex items-center space-x-4">
                @if (Auth::user()->profile_photo_path)
                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="Foto Profil"
                        class="h-20 w-20 rounded-full object-cover">
                @else
                    <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif
                <input id="profile_photo" name="profile_photo" type="file"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="border-t pt-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="nama_lengkap">
                        <span class="flex items-center">
                            Nama Lengkap
                        </span>
                    </x-input-label>
                    <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full"
                        :value="old('nama_lengkap', $user->nama_lengkap)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
                </div>
                <div>
                    <x-input-label for="username">
                        <span class="flex items-center">
                            Username
                        </span>
                    </x-input-label>
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                        :value="old('username', $user->username)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>
            </div>

            <div>
                <x-input-label for="no_telepon">
                    <span class="flex items-center">
                        Nomor Telepon
                    </span>
                </x-input-label>
                <x-text-input id="no_telepon" name="no_telepon" type="text" class="mt-1 block w-full"
                    :value="old('no_telepon', $user->no_telepon)" />
                <x-input-error class="mt-2" :messages="$errors->get('no_telepon')" />
            </div>

            <div>
                <x-input-label for="jalan">
                    <span class="flex items-center">
                        Alamat Jalan
                    </span>
                </x-input-label>
                <x-text-input id="jalan" name="jalan" type="text" class="mt-1 block w-full"
                    :value="old('jalan', $user->jalan)" />
                <x-input-error class="mt-2" :messages="$errors->get('jalan')" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="rt" :value="__('RT')" />
                    <x-text-input id="rt" name="rt" type="text" class="mt-1 block w-full"
                        :value="old('rt', $user->rt)" />
                    <x-input-error class="mt-2" :messages="$errors->get('rt')" />
                </div>
                <div>
                    <x-input-label for="rw" :value="__('RW')" />
                    <x-text-input id="rw" name="rw" type="text" class="mt-1 block w-full"
                        :value="old('rw', $user->rw)" />
                    <x-input-error class="mt-2" :messages="$errors->get('rw')" />
                </div>
            </div>

            <div class="mt-4 p-4 bg-gray-50 rounded-md border">
                <span class="block font-medium text-sm text-gray-700">Lokasi Terdaftar</span>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $user->desa->nama_desa ?? 'Belum diatur' }}, {{ $user->desa->kecamatan->nama_kecamatan ?? '' }}
                </p>
                <small class="text-gray-500">Lokasi hanya dapat diubah oleh Admin Data.</small>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
