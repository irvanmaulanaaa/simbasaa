<div class="flex flex-col space-y-1">

    @php
        $activeClass = 'flex items-center px-3 py-3 text-lg font-medium bg-green-600 text-white rounded-md';
        $inactiveClass =
            'flex items-center px-3 py-3 text-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md';
    @endphp

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Dashboard
    </h3>

    <a href="{{ route('admin-data.dashboard') }}"
        class="{{ request()->routeIs('admin-data.dashboard') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-home class="h-6 w-6 mr-3" />
        {{ __('Home') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Manajemen Data
    </h3>

    <a href="{{ route('admin-data.users.index') }}"
        class="{{ request()->routeIs('admin-data.users.*') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-users class="h-6 w-6 mr-3" />
        {{ __('Pengguna') }}
    </a>

    <a href="{{ route('admin-data.konten.index') }}"
        class="{{ request()->routeIs('admin-data.konten.*') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-document-text class="h-6 w-6 mr-3" />
        {{ __('Konten') }}
    </a>

    <a href="{{ route('admin-data.kecamatan.index') }}"
        class="{{ request()->routeIs('admin-data.kecamatan.*') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-building-office-2 class="h-6 w-6 mr-3" />
        {{ __('Kecamatan') }}
    </a>

    <a href="{{ route('admin-data.desa.index') }}"
        class="{{ request()->routeIs('admin-data.desa.*') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-building-office class="h-6 w-6 mr-3" />
        {{ __('Desa') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Welcome Page
    </h3>

    <a href="{{ url('/') }}" class="{{ $inactiveClass }}">
        <x-heroicon-o-square-3-stack-3d class="h-6 w-6 mr-3" />
        {{ __('Halaman Utama') }}
    </a>
    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Logout
    </h3>
</div>

<div class_="mt-6 pt-6 border-t border-gray-200">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}"
            class="flex items-center px-3 py-3 text-lg font-medium text-red-600 hover:bg-red-600 hover:text-white rounded-md"
            onclick="event.preventDefault(); this.closest('form').submit();">

            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            {{ __('Keluar') }}
        </a>
    </form>
</div>
