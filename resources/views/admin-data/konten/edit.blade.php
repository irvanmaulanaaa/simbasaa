<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-green-600">Home</a>
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
                            <span class="ms-1 text-lg font-medium text-gray-500 md:ms-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                <div class="p-8 text-gray-900">

                    <form id="kontenForm" action="{{ route('admin-data.konten.update', $konten->id_konten) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                Media Konten
                            </h3>

                            <div class="flex items-center space-x-6 mb-4 ml-1">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="media_type" value="upload"
                                        class="form-radio text-green-600 focus:ring-green-500 h-5 w-5"
                                        @if (old('media_type', $mediaType) == 'upload') checked @endif>
                                    <span class="ml-2 text-gray-700 font-medium">Upload Gambar</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="media_type" value="url"
                                        class="form-radio text-green-600 focus:ring-green-500 h-5 w-5"
                                        @if (old('media_type', $mediaType) == 'url') checked @endif>
                                    <span class="ml-2 text-gray-700 font-medium">Link URL YouTube</span>
                                </label>
                            </div>

                            <div id="input-upload" class="transition-opacity duration-300">
                                <div id="dropzone-box"
                                    class="border-2 border-dashed border-blue-300 hover:border-green-500 rounded-xl p-8 text-center cursor-pointer bg-white hover:bg-green-50 transition relative group"
                                    onclick="document.getElementById('media_file').click()">

                                    <input id="media_file" type="file" name="media_file" class="hidden"
                                        accept="image/*,video/*" onchange="previewFile()">

                                    <div id="dropzone-content" class="@if ($mediaType == 'upload' && $mediaValue) hidden @endif">
                                        <div
                                            class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                            <svg class="h-8 w-8 text-blue-600" stroke="currentColor" fill="none"
                                                viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600"><span
                                                class="font-bold text-green-600 hover:underline">Klik di sini</span>
                                            untuk mengganti gambar</p>
                                        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah</p>
                                    </div>

                                    <div id="preview-container"
                                        class="relative {{ $mediaType == 'upload' && $mediaValue ? 'inline-block' : 'hidden' }}">
                                        <img id="image-preview"
                                            src="{{ $mediaType == 'upload' && $mediaValue ? asset('storage/' . $mediaValue) : '' }}"
                                            class="max-h-80 mx-auto rounded-lg shadow-lg object-contain border border-gray-200" />

                                        <button type="button" onclick="removeImage(event)"
                                            class="absolute -top-3 -right-3 bg-red-600 text-white rounded-full p-1.5 hover:bg-red-700 shadow-md transition transform hover:scale-110"
                                            title="Hapus Gambar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>

                                        <p id="file-name"
                                            class="mt-3 text-sm text-green-700 font-bold bg-green-100 inline-block px-3 py-1 rounded-full">
                                            {{ $mediaType == 'upload' && $mediaValue ? 'Gambar Saat Ini' : '' }}
                                        </p>
                                    </div>
                                </div>
                                @error('media_file')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="input-url" class="hidden transition-opacity duration-300">
                                <x-input-label for="media_url" :value="__('Link URL YouTube')" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                    </div>
                                    <input id="media_url" type="text" name="media_url"
                                        class="pl-10 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        value="{{ old('media_url', $mediaType == 'url' ? $mediaValue : '') }}"
                                        oninput="checkLinkPreview()">
                                </div>
                                @error('media_url')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror

                                <div id="youtube-preview-container"
                                    class="mt-4 hidden bg-black rounded-lg overflow-hidden shadow-lg">
                                    <div class="aspect-w-16 aspect-h-9">
                                        <iframe id="youtube-iframe" class="w-full h-64 md:h-96" src=""
                                            frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div id="url-image-preview-container" class="mt-4 hidden text-center">
                                    <img id="url-image-preview"
                                        class="max-h-80 mx-auto rounded-lg shadow-lg border border-gray-200"
                                        src="" alt="Preview Link">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                Detail Informasi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="judul" :value="__('Judul Konten')" />
                                    <x-text-input id="judul"
                                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        type="text" name="judul" :value="old('judul', $konten->judul)" required />
                                    @error('judul')
                                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <x-input-label for="status_id" :value="__('Status Publikasi')" />
                                    <select id="status_id" name="status_id"
                                        class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm bg-white"
                                        required>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id_status }}"
                                                {{ old('status_id', $konten->status_id) == $status->id_status ? 'selected' : '' }}>
                                                {{ ucfirst($status->nama_status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <x-input-label for="deskripsi" :value="__('Deskripsi Konten')"
                                class="text-lg font-bold text-gray-800 mb-2" />
                            <textarea id="deskripsi" name="deskripsi" rows="8"
                                class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-xl shadow-sm p-4">{{ old('deskripsi', $konten->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end border-t border-gray-200 pt-6 space-x-3">
                            <a href="{{ route('admin-data.konten.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Batal</a>
                            <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-lg transform hover:scale-105 transition duration-200">
                                {{ __('Update Konten') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div id="loadingOverlay"
                    class="absolute inset-0 bg-white bg-opacity-90 z-50 hidden flex-col items-center justify-center rounded-lg">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600 mb-4"></div>
                    <p class="text-green-700 font-bold text-lg animate-pulse">Menyimpan Perubahan...</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kontenForm = document.getElementById('kontenForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        kontenForm.addEventListener('submit', function() {
            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');
        });

        @if (session('success_update'))
            loadingOverlay.classList.add('hidden');
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diupdate!',
                text: '{{ session('success_update') }}',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = "{{ route('admin-data.konten.index') }}";
            });
        @endif

        @if ($errors->any())
            loadingOverlay.classList.add('hidden');
            Swal.fire({
                icon: 'error',
                title: 'Gagal Update!',
                text: 'Mohon periksa inputan Anda.',
                confirmButtonColor: '#dc2626'
            });
        @endif

        const mediaTypeRadios = document.querySelectorAll('input[name="media_type"]');
        const inputUploadDiv = document.getElementById('input-upload');
        const inputUrlDiv = document.getElementById('input-url');
        const fileInput = document.getElementById('media_file');
        const urlInput = document.getElementById('media_url');

        const initialValue = '{{ old('media_type', $mediaType) }}';

        function toggleInputs(value) {
            if (value === 'upload') {
                inputUploadDiv.classList.remove('hidden');
                inputUrlDiv.classList.add('hidden');
                if (urlInput) urlInput.value = '';
                document.getElementById('youtube-preview-container').classList.add('hidden');
                document.getElementById('url-image-preview-container').classList.add('hidden');
            } else if (value === 'url') {
                inputUploadDiv.classList.add('hidden');
                inputUrlDiv.classList.remove('hidden');
                if (fileInput) fileInput.value = null;
                checkLinkPreview();
            }
        }

        mediaTypeRadios.forEach(radio => {
            if (radio.value === initialValue) radio.checked = true;
            radio.addEventListener('change', function() {
                toggleInputs(this.value);
            });
        });
        toggleInputs(initialValue);
    });

    function previewFile() {
        const preview = document.getElementById('image-preview');
        const fileInput = document.getElementById('media_file');
        const dropzoneContent = document.getElementById('dropzone-content');
        const previewContainer = document.getElementById('preview-container');
        const fileNameDisplay = document.getElementById('file-name');

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function() {
            preview.src = reader.result;
            dropzoneContent.classList.add('hidden');
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('inline-block');
            fileNameDisplay.textContent = "File Baru: " + file.name;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function removeImage(event) {
        event.stopPropagation();
        const fileInput = document.getElementById('media_file');
        const dropzoneContent = document.getElementById('dropzone-content');
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('image-preview');

        fileInput.value = '';
        preview.src = '';

        previewContainer.classList.add('hidden');
        previewContainer.classList.remove('inline-block');
        dropzoneContent.classList.remove('hidden');
    }

    function checkLinkPreview() {
        const url = document.getElementById('media_url').value;
        const youtubeContainer = document.getElementById('youtube-preview-container');
        const iframe = document.getElementById('youtube-iframe');
        const imgContainer = document.getElementById('url-image-preview-container');
        const imgPreview = document.getElementById('url-image-preview');
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/;
        const imageRegex = /\.(jpeg|jpg|gif|png|webp|bmp|svg)(\?.*)?$/i;

        if (youtubeRegex.test(url)) {
            let videoId = '';
            try {
                if (url.includes('v=')) {
                    videoId = url.split('v=')[1].split('&')[0];
                } else if (url.includes('youtu.be/')) {
                    videoId = url.split('youtu.be/')[1].split('?')[0];
                } else if (url.includes('embed/')) {
                    videoId = url.split('embed/')[1].split('?')[0];
                }

                if (videoId) {
                    iframe.src = "https://www.youtube.com/embed/" + videoId;
                    youtubeContainer.classList.remove('hidden');
                    imgContainer.classList.add('hidden');
                }
            } catch (e) {
                console.log("Error YouTube");
            }
        } else if (imageRegex.test(url)) {
            imgPreview.src = url;
            imgContainer.classList.remove('hidden');
            youtubeContainer.classList.add('hidden');
        } else {
            youtubeContainer.classList.add('hidden');
            iframe.src = "";
            imgContainer.classList.add('hidden');
        }
    }
</script>
