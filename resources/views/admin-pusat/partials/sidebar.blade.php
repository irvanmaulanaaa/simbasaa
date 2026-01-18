<div class="flex-1 flex flex-col space-y-1">
    @php
        $activeClass = 'flex items-center px-3 py-3 text-lg font-medium bg-green-600 text-white rounded-md';
        $inactiveClass =
            'flex items-center px-3 py-3 text-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md';
    @endphp

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Dashboard
    </h3>

    <a href="{{ route('admin-pusat.dashboard') }}"
        class="{{ request()->routeIs('admin-pusat.dashboard') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-home class="h-6 w-6 mr-3" />
        {{ __('Home') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Operasional
    </h3>

    <a href="{{ route('admin-pusat.sampah.index') }}"
        class="{{ request()->routeIs('admin-pusat.sampah.*') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('Data Sampah') }}
    </a>

    <a href="{{ route('admin-pusat.kategori-sampah.index') }}"
        class="{{ request()->routeIs('admin-pusat.kategori-sampah.*') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
        </svg>
        {{ __('Kategori Sampah') }}
    </a>

    <a href="{{ route('admin-pusat.jadwal.index') }}"
        class="{{ request()->routeIs('admin-pusat.jadwal.*') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
        </svg>
        {{ __('Jadwal Penimbangan') }}
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
        Log Out
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
