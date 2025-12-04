<div class="flex flex-col space-y-1">
    @php
        $activeClass = 'flex items-center px-3 py-3 text-sm font-medium bg-green-600 text-white rounded-md';
        $inactiveClass = 'flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md';
    @endphp

    <a href="{{ route('ketua.dashboard') }}" 
       class="{{ request()->routeIs('ketua.dashboard') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
        </svg>
        {{ __('Dashboard / Riwayat') }}
    </a>

    <h3 class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Transaksi
    </h3>

    <a href="{{ route('ketua.setoran.create') }}" 
       class="{{ request()->routeIs('ketua.setoran.*') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        {{ __('Input Setoran Warga') }}
    </a>

    <a href="{{ route('ketua.penarikan.index') }}" 
       class="{{ request()->routeIs('ketua.penarikan.*') ? $activeClass : $inactiveClass }}">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('Validasi Penarikan') }}
    </a>

    <div class="mt-6 pt-6 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" class="flex items-center px-3 py-3 text-sm font-medium text-red-700 hover:bg-red-600 hover:text-white rounded-md" onclick="event.preventDefault(); this.closest('form').submit();">
                <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                {{ __('Keluar') }}
            </a>
        </form>
    </div>
</div>