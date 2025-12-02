<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-pusat.partials.sidebar')
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Penimbangan') }}
        </h2>
    </x-slot>
    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-pusat.dashboard') }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin-pusat.jadwal.index') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Jadwal Penimbangan</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin-pusat.jadwal.update', $jadwal->id_jadwal) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_jadwal" :value="__('Tanggal Kegiatan')" />
                                <x-text-input id="tgl_jadwal" class="block mt-1 w-full" type="date" name="tgl_jadwal"
                                    :value="old('tgl_jadwal', $jadwal->tgl_jadwal)" required />
                                <x-input-error :messages="$errors->get('tgl_jadwal')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jam_penimbangan" :value="__('Jam Mulai')" />
                                <x-text-input id="jam_penimbangan" class="block mt-1 w-full" type="time"
                                    name="jam_penimbangan" :value="old(
                                        'jam_penimbangan',
                                        \Carbon\Carbon::parse($jadwal->jam_penimbangan)->format('H:i'),
                                    )" required />
                                <x-input-error :messages="$errors->get('jam_penimbangan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="desa_id" :value="__('Lokasi Desa')" />
                                <select id="desa_id" name="desa_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">-- Pilih Desa --</option>
                                    @foreach ($desas as $desa)
                                        <option value="{{ $desa->id_desa }}"
                                            @if ($jadwal->desa_id == $desa->id_desa) selected @endif>
                                            {{ $desa->nama_desa }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('desa_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="rw_penimbangan" :value="__('Lokasi RW')" />
                                <x-text-input id="rw_penimbangan" class="block mt-1 w-full" type="text"
                                    name="rw_penimbangan" :value="old('rw_penimbangan', $jadwal->rw_penimbangan)" required />
                                <x-input-error :messages="$errors->get('rw_penimbangan')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>{{ __('Update Jadwal') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
