<x-app-layout>
    <x-slot name="sidebar">
        @include('admin-data.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Konten') }}
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
                                Pengguna</a>
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
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong> Ada masalah dengan input Anda.
                        </div>
                    @endif

                    <form action="{{ route('admin-data.konten.update', $konten->id_konten) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="judul" :value="__('Judul Artikel')" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul', $konten->judul)" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi" :value="__('Isi Konten')" />
                            <textarea id="deskripsi" name="deskripsi" rows="10" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('deskripsi', $konten->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="status_id" :value="__('Status')" />
                            <select id="status_id" name="status_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required 
                                @if($konten->status->nama_status == 'published') disabled @endif>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id_status }}" @if(old('status_id', $konten->status_id) == $status->id_status) selected @endif>
                                        {{ ucfirst($status->nama_status) }}
                                    </option>
                                @endforeach
                            </select>
                            @if($konten->status->nama_status == 'published')
                                <input type="hidden" name="status_id" value="{{ $konten->status_id }}" />
                            @endif
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Media Konten (Opsional)')" />
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="media_type" value="upload" class="form-radio" 
                                        @if(old('media_type', $mediaType) == 'upload') checked @endif>
                                    <span class="ml-2">Upload Gambar</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" name="media_type" value="url" class="form-radio"
                                        @if(old('media_type', $mediaType) == 'url') checked @endif>
                                    <span class="ml-2">Link URL Eksternal</span>
                                </label>
                            </div>
                        </div>

                        <div id="input-upload" class="mb-4">
                            <x-input-label for="media_file" :value="__('Ganti Gambar/Video (Kosongkan jika tidak diubah)')" />
                            <input id="media_file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer" type="file" name="media_file">
                            @if($mediaType == 'upload' && $mediaValue)
                                <small class="text-gray-500">File saat ini: {{ $mediaValue }}</small>
                            @endif
                        </div>

                        <div id="input-url" class="mb-4">
                            <x-input-label for="media_url" :value="__('Sematkan Link URL')" />
                            <x-text-input id="media_url" class="block mt-1 w-full" type="text" name="media_url" 
                                :value="old('media_url', $mediaType == 'url' ? $mediaValue : '')" placeholder="https://..." />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Update Konten') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mediaTypeRadios = document.querySelectorAll('input[name="media_type"]');
            const inputUploadDiv = document.getElementById('input-upload');
            const inputUrlDiv = document.getElementById('input-url');
            const fileInput = document.getElementById('media_file');
            const urlInput = document.getElementById('media_url');

            function toggleInputs(value) {
                if (value === 'upload') {
                    inputUploadDiv.classList.remove('hidden');
                    inputUrlDiv.classList.add('hidden');
                } else if (value === 'url') {
                    inputUploadDiv.classList.add('hidden');
                    inputUrlDiv.classList.remove('hidden');
                }
            }

            const initialValue = document.querySelector('input[name="media_type"]:checked').value;
            toggleInputs(initialValue);

            mediaTypeRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    toggleInputs(this.value);
                });
            });
        });
    </script>
</x-app-layout>