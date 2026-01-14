<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <div class="flex items-center lg:hidden">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <x-heroicon-o-bars-3-center-left class="h-6 w-6" />
                    </button>
                </div>

                <div class="ml-3 lg:ml-0">
                    @if (isset($breadcrumbs))
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                {{ $breadcrumbs }}
                            </ol>
                        </nav>
                    @elseif (isset($header))
                        {{ $header }}
                    @endif
                </div>
            </div>

            <div class="flex items-center sm:ms-6 space-x-3">

                <div x-data="{
                    openNotif: false,
                    showDetail: false,
                    isLoading: false, 
                    notifications: [],
                    count: 0,
                    detail: {},
                
                    async fetchNotif() {
                        try {
                            let res = await fetch('{{ route('notifications.latest') }}');
                            let data = await res.json();
                            this.notifications = data.data;
                            this.count = data.count;
                        } catch (e) { console.error(e); }
                    },
                
                    async openModal(notif) {
                        this.detail = notif;
                        this.openNotif = false;
                        this.showDetail = true;
                
                        if (!notif.is_read) {
                            await fetch('{{ route('notifications.read') }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ id: notif.id_notif })
                            });
                            this.fetchNotif();
                        }
                    },
                
                    async deleteNotif() {
                        const result = await Swal.fire({
                            title: 'Hapus Notifikasi?',
                            text: 'Notifikasi ini akan dihapus permanen dari daftar Anda.',
                            icon: 'warning',
                            backdrop: `rgba(220, 38, 38, 0.4)`, 
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#1f2937',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: { popup: 'rounded-xl shadow-2xl' }
                        });
                
                        if (result.isConfirmed) {
                            this.isLoading = true;
                            this.showDetail = false; 
                
                            try {
                                await fetch('{{ route('notifications.delete') }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                    body: JSON.stringify({ id: this.detail.id_notif })
                                });
                                
                                await new Promise(r => setTimeout(r, 500));
                
                                this.isLoading = false;
                
                                await Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Notifikasi berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    backdrop: `rgba(0, 0, 0, 0.4)`
                                });
                
                                this.fetchNotif();
                            } catch (error) {
                                this.isLoading = false; 
                                Swal.fire('Error', 'Gagal menghapus notifikasi.', 'error');
                            }
                        }
                    },
                
                    formatDate(dateStr) {
                        return new Date(dateStr).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                    }
                }" x-init="fetchNotif()" class="relative mr-2">
                
                    <div x-show="isLoading"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-white bg-opacity-90 z-[9999] flex flex-col items-center justify-center"
                        style="display: none;">
                        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-red-600 mb-4"></div>
                        <p class="text-red-700 font-bold text-lg animate-pulse">Menghapus Notifikasi...</p>
                    </div>

                    <button @click="openNotif = !openNotif"
                        class="relative p-1 rounded-full text-gray-400 hover:text-gray-600 transition focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <div x-show="count > 0"
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/4 -translate-y-1/4"
                            style="display: none;">
                            <span x-text="count > 9 ? '9+' : count"></span>
                        </div>
                    </button>

                    <div x-show="openNotif" @click.away="openNotif = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="origin-top-right absolute right-0 mt-2 w-80 rounded-lg shadow-xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                        style="display: none;">

                        <div
                            class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-lg flex justify-between items-center">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wide">Notifikasi</h3>
                            <span class="text-[10px] bg-blue-100 text-blue-800 py-0.5 px-2 rounded-full"
                                x-text="count + ' Baru'"></span>
                        </div>

                        <div class="max-h-80 overflow-y-auto custom-scrollbar">
                            <template x-for="notif in notifications" :key="notif.id_notif">
                                <a href="#" @click.prevent="openModal(notif)"
                                    class="block px-4 py-3 transition border-b border-gray-100 last:border-0 group hover:bg-gray-50"
                                    :class="notif.is_read ? 'bg-white' : 'bg-blue-50/60'">

                                    <div class="flex gap-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="h-8 w-8 rounded-full flex items-center justify-center"
                                                :class="notif.is_read ? 'bg-gray-100 text-gray-400' :
                                                    'bg-blue-100 text-blue-600'">
                                                <i class="fas fa-bell text-xs"></i>
                                                <svg x-show="!notif.is_read" class="w-4 h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                                    </path>
                                                </svg>
                                                <svg x-show="notif.is_read" class="w-4 h-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate group-hover:text-blue-600 transition"
                                                x-text="notif.judul"></p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                RW <span x-text="notif.rw_kegiatan"></span> &bull; <span
                                                    x-text="formatDate(notif.tgl_kegiatan)"></span>
                                            </p>
                                        </div>
                                        <div x-show="!notif.is_read" class="flex-shrink-0 self-center">
                                            <span
                                                class="block h-2 w-2 bg-blue-600 rounded-full ring-2 ring-white"></span>
                                        </div>
                                    </div>
                                </a>
                            </template>
                            <div x-show="notifications.length === 0"
                                class="px-4 py-8 text-center text-sm text-gray-500 flex flex-col items-center">
                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                Tidak ada notifikasi saat ini.
                            </div>
                        </div>
                    </div>

                    <div x-show="showDetail" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                            @click="showDetail = false"></div>

                        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                                @click.away="showDetail = false">

                                <div
                                    class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4 flex items-center justify-between">
                                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Detail Notifikasi
                                    </h3>
                                    <button @click="showDetail = false"
                                        class="text-blue-100 hover:text-white transition">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="px-6 py-6">
                                    <div class="text-center mb-6">
                                        <h4 class="text-xl font-bold text-gray-900 leading-snug"
                                            x-text="detail.judul"></h4>
                                    </div>

                                    <div
                                        class="bg-gray-50 rounded-xl p-4 border border-gray-100 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Tanggal</span>
                                            <div class="flex items-center gap-2 text-sm font-bold text-gray-800">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span x-text="formatDate(detail.tgl_kegiatan)"></span>
                                            </div>
                                        </div>

                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Waktu</span>
                                            <div class="flex items-center gap-2 text-sm font-bold text-gray-800">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <span x-text="detail.jam_kegiatan + ' WIB'"></span>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2 border-t border-gray-200 pt-3 mt-1">
                                            <span
                                                class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1 block">Lokasi</span>
                                            <div class="flex items-start gap-3 text-sm text-gray-800">
                                                <div class="bg-blue-100 p-1.5 rounded-full mt-0.5">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-bold text-gray-900">RW <span
                                                            x-text="detail.rw_kegiatan"></span></p>
                                                    <p class="text-gray-600">Desa <span
                                                            x-text="detail.desa_kegiatan"></span></p>
                                                    <p class="text-gray-600">Kec. <span
                                                            x-text="detail.kecamatan_kegiatan"></span></p>
                                                    <p class="text-gray-600">
                                                        <span x-text="detail.kab_kota"></span>,
                                                        <span x-text="detail.provinsi || 'Jawa Barat'"></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:items-center gap-3">
                                    <button type="button" @click="deleteNotif()"
                                        class="inline-flex w-full justify-center items-center rounded-lg border border-transparent bg-red-100 px-3 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-200 focus:outline-none sm:w-auto transition group">
                                        <svg class="w-4 h-4 mr-1.5 group-hover:animate-bounce" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus Notifikasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 cursor-default select-none pl-2 border-l border-gray-200">
                    @if (Auth::user()->profile_photo_path)
                        <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                            alt="{{ Auth::user()->nama_lengkap }}"
                            class="h-9 w-9 rounded-full object-cover shadow-sm border-2 border-white ring-1 ring-gray-100">
                    @else
                        <div
                            class="h-9 w-9 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-sm shadow-sm border-2 border-white ring-1 ring-gray-100">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                        </div>
                    @endif

                    <div class="hidden sm:flex flex-col text-left">
                        <span class="font-bold text-sm text-gray-800 leading-tight">
                            {{ Auth::user()->nama_lengkap }}
                        </span>
                        <span class="text-xs text-gray-500 font-medium">
                            {{ Auth::user()->username }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
