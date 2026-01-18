<div class="flex-1 flex flex-col space-y-1">
    @php
        $activeClass = 'flex items-center px-3 py-3 text-lg font-medium bg-green-600 text-white rounded-md';
        $inactiveClass =
            'flex items-center px-3 py-3 text-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md';
    @endphp

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Dashboard
    </h3>

    <a href="{{ route('ketua.dashboard') }}"
        class="{{ request()->routeIs('ketua.dashboard') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-home class="h-6 w-6 mr-3" />
        {{ __('Home') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Transaksi
    </h3>

    <a href="{{ route('ketua.setoran.index') }}"
        class="{{ request()->routeIs('ketua.setoran.*') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-banknotes class="h-6 w-6 mr-3" />
        {{ __('Setoran Warga') }}
    </a>

    <a href="{{ route('ketua.penarikan.index') }}"
        class="{{ request()->routeIs('ketua.penarikan.*') ? $activeClass : $inactiveClass }} flex items-center justify-between group relative">

        <div class="flex items-center">
            <x-heroicon-o-check-badge class="h-6 w-6 mr-3" />
            {{ __('Validasi Penarikan') }}
        </div>

        <span id="badge-pending"
            class="hidden bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 shadow-sm animate-pulse">
            0
        </span>
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Akun Saya
    </h3>

    <a href="{{ route('profile.show') }}"
        class="{{ request()->routeIs('profile.*') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
        {{ __('Profile Saya') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Welcome Page
    </h3>

    <a href="{{ url('/') }}" class="{{ $inactiveClass }}">
        <x-heroicon-o-square-3-stack-3d class="h-6 w-6 mr-3" />
        {{ __('Halaman Utama') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        LogOut
    </h3>

    <div class="mt-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
                class="flex items-center px-3 py-3 text-lg font-medium text-red-700 hover:bg-red-600 hover:text-white rounded-md"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <x-heroicon-o-arrow-right-start-on-rectangle class="h-6 w-6 mr-3" />
                {{ __('Keluar') }}
            </a>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchNotifikasi();

        setInterval(fetchNotifikasi, 10000);
    });

    function fetchNotifikasi() {
        fetch("{{ route('ketua.api.count-pending') }}")
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('badge-pending');
                if (data.count > 0) {
                    badge.innerText = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Gagal mengambil notifikasi:', error));
    }
</script>
