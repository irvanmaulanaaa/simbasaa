<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin-data.users.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text"
                                    name="nama_lengkap" :value="old('nama_lengkap')" required />
                            </div>
                            <div>
                                <x-input-label for="username" :value="__('Username (untuk login)')" />
                                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                                    :value="old('username')" required />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="kecamatan_id" :value="__('Kecamatan')" />
                                <select id="kecamatan_id" name="kecamatan_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id_kecamatan }}">{{ $kecamatan->nama_kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="desa_id" :value="__('Desa')" />
                                <select id="desa_id" name="desa_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">Pilih Desa (Pilih Kecamatan Dulu)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="rt" :value="__('RT')" />
                                <x-text-input id="rt" class="block mt-1 w-full" type="text" name="rt"
                                    :value="old('rt')" required />
                            </div>
                            <div>
                                <x-input-label for="rw" :value="__('RW')" />
                                <x-text-input id="rw" class="block mt-1 w-full" type="text" name="rw"
                                    :value="old('rw')" required />
                            </div>
                            <div>
                                <x-input-label for="role_id" :value="__('Role')" />
                                <select id="role_id" name="role_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id_role }}">{{ $role->nama_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const kecamatanSelect = document.getElementById('kecamatan_id');
        const desaSelect = document.getElementById('desa_id');

        kecamatanSelect.addEventListener('change', function() {
            const kecamatanId = this.value;

            desaSelect.innerHTML = '<option value="">Memuat...</option>';
            desaSelect.disabled = true;

            if (kecamatanId) {
                fetch(`{{ route('admin-data.users.get-desa') }}?kecamatan_id=${kecamatanId}`)
                    .then(response => response.json())
                    .then(data => {
                        desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                        data.forEach(desa => {
                            desaSelect.innerHTML +=
                                `<option value="${desa.id_desa}">${desa.nama_desa}</option>`;
                        });
                        desaSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        desaSelect.innerHTML = '<option value="">Gagal memuat desa</option>';
                    });
            } else {
                desaSelect.innerHTML = '<option value="">Pilih Kecamatan Dulu</option>';
                desaSelect.disabled = true;
            }
        });
    });
</script>
