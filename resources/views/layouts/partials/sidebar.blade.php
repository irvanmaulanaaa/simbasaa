<aside class="w-64" aria-label="Sidebar">
    <div class="overflow-y-auto py-4 px-3 bg-white h-full">
        <a href="#" class="flex items-center ps-2.5 mb-5">
            <span class="self-center text-xl font-semibold whitespace-nowrap text-black">Bank Sampah</span>
        </a>

        <ul class="space-y-2">
            <li>
                @php $isActive = request()->routeIs('admin.warga.*'); @endphp
                <a href="{{ route('admin.warga.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg
                          {{ $isActive ? 'bg-green-700 text-white' : 'text-black hover:bg-green-400' }}">
                    <span class="ms-3">Kelola Warga</span>
                </a>
            </li>
            <li>
                @php $isActive = request()->routeIs('admin.jenis_sampah.*'); @endphp
                <a href="{{ route('admin.jenis_sampah.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg
              {{ $isActive ? 'bg-green-700 text-white' : 'text-black hover:bg-green-400' }}">
                    <span class="ms-3">Kelola Sampah</span>
                </a>
            </li>
            <li>
                @php $isActive = request()->routeIs('admin.setoran.*'); @endphp
                <a href="{{ route('admin.setoran.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg
                  {{ $isActive ? 'bg-green-700 text-white' : 'text-black hover:bg-green-400' }}">
                    <span class="ms-3">Setoran Sampah</span>
                </a>
            </li>
            <li>
                @php $isActive = request()->routeIs('admin.penarikan.*'); @endphp
                <a href="{{ route('admin.penarikan.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg
              {{ $isActive ? 'bg-green-700 text-white' : 'text-black hover:bg-green-400' }}">
                    <span class="ms-3">Permintaan Penarikan</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
