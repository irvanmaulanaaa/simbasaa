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
        {{ __('Home') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Manajemen Data
    </h3>

    <a href="{{ route('admin-data.kecamatan.index') }}"
        class="{{ request()->routeIs('admin-data.kecamatan.*') ? $activeClass : $inactiveClass }}">
        {{ __('Kecamatan') }}
    </a>

    <a href="{{ route('admin-data.desa.index') }}"
        class="{{ request()->routeIs('admin-data.desa.*') ? $activeClass : $inactiveClass }}">
        {{ __('Desa') }}
    </a>

    <a href="{{ route('admin-data.users.index') }}"
        class="{{ request()->routeIs('admin-data.users.*') ? $activeClass : $inactiveClass }}">
        {{ __('Pengguna') }}
    </a>

    <a href="{{ route('admin-data.konten.index') }}"
        class="{{ request()->routeIs('admin-data.konten.*') ? $activeClass : $inactiveClass }}">
        {{ __('Konten') }}
    </a>
</div>
