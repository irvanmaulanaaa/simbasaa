<div class="flex-1 flex flex-col space-y-1">
    @php
        $activeClass = 'flex items-center px-3 py-3 text-lg font-medium bg-green-600 text-white rounded-md';
        $inactiveClass =
            'flex items-center px-3 py-3 text-lg font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md';

        $notifTolak = \App\Models\Penarikan::where('warga_id', Auth::user()->id_user)
            ->where('status', 'ditolak')
            ->where('is_read', 0)
            ->count();
    @endphp

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Dashboard
    </h3>

    <a href="{{ route('warga.dashboard') }}"
        class="{{ request()->routeIs('warga.dashboard') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        {{ __('Home') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Keuangan
    </h3>

    <a href="{{ route('warga.penarikan.index') }}"
        class="{{ request()->routeIs('warga.penarikan.*') ? $activeClass : $inactiveClass }}">
        <div class="flex items-center">
            <x-heroicon-o-clipboard-document-list class="h-6 w-6 mr-3" />
            {{ __('Riwayat Penarikan') }}
        </div>

        @if ($notifTolak > 0)
            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">
                {{ $notifTolak }}
            </span>
        @endif
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Aktivitas
    </h3>

    <a href="{{ route('warga.setoran.index') }}"
        class="{{ request()->routeIs('warga.setoran.*') ? $activeClass : $inactiveClass }}">
        <x-heroicon-o-inbox-arrow-down class="h-6 w-6 mr-3" />
        {{ __('Riwayat Setoran') }}
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
        Log out
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
