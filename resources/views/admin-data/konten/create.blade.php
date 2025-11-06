<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Konten') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin-data.dashboard') }}"
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin-data.konten.index') }}"
                                class="ms-1 text-lg font-medium text-gray-700 hover:text-green-600 md:ms-2">Manajemen
                                Konten</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Whoops! Ada yang salah.</strong>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin-data.konten.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="judul" :value="__('Judul Konten')" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul"
                                :value="old('judul')" required />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi" :value="__('Isi Konten')" />
                            <textarea id="deskripsi" name="deskripsi" rows="10"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="status_id" :value="__('Status')" />
                            <select id="status_id" name="status_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Pilih Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id_status }}">{{ ucfirst($status->nama_status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label :value="__('Media Konten')" />
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="media_type" value="upload" class="form-radio"
                                        @if (old('media_type', 'upload') == 'upload') checked @endif>
                                    <span class="ml-2">Upload Gambar</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" name="media_type" value="url" class="form-radio"
                                        @if (old('media_type') == 'url') checked @endif>
                                    <span class="ml-2">Link URL Eksternal</span>
                                </label>
                            </div>
                        </div>

                        <div id="input-upload" class="mb-4">
                            <x-input-label for="media_file" :value="__('Upload Gambar/Video')" />
                            <input id="media_file"
                                class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                type="file" name="media_file">
                            <x-input-error :messages="$errors->get('media_file')" class="mt-2" />
                        </div>

                        <div id="input-url" class="mb-4 hidden">
                            <x-input-label for="media_url" :value="__('Sematkan Link URL')" />
                            <x-text-input id="media_url" class="block mt-1 w-full" type="text" name="media_url"
                                :value="old('media_url')" placeholder="https://contoh.com/gambar.jpg" />
                            <x-input-error :messages="$errors->get('media_url')" class="mt-2" />
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
        const mediaTypeRadios = document.querySelectorAll('input[name="media_type"]');
        const inputUploadDiv = document.getElementById('input-upload');
        const inputUrlDiv = document.getElementById('input-url');

        const fileInput = document.getElementById('media_file');
        const urlInput = document.getElementById('media_url');


        const initialValue = '{{ old('media_type', 'upload') }}';

        function toggleInputs(value) {
            if (value === 'upload') {
                inputUploadDiv.classList.remove('hidden');
                inputUrlDiv.classList.add('hidden');

                if (urlInput) {
                    urlInput.value = '';
                }
            } else if (value === 'url') {
                inputUploadDiv.classList.add('hidden');
                inputUrlDiv.classList.remove('hidden');

                if (fileInput) {
                    fileInput.value = null;
                }
            }
        }

        mediaTypeRadios.forEach(radio => {
            if (radio.value === initialValue) {
                radio.checked = true;
            }
        });

        toggleInputs(initialValue);

        mediaTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                toggleInputs(this.value);
            });
        });
    });
</script>
