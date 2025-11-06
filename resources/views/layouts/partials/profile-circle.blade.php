<a href="{{ route('profile.edit') }}" class="flex-shrink-0">
    <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-white font-bold" title="Profile">
        {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
    </div>
</a>