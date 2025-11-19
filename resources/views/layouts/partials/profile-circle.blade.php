<a href="{{ route('profile.show') }}" class="flex-shrink-0" title="Edit Profile">
    @if (Auth::user()->profile_photo_path)
        <img class="h-8 w-8 rounded-full object-cover ring-2 ring-offset-2 ring-green-300" src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="Foto Profil">
    @else
        <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-white font-bold ring-2 ring-offset-2 ring-green-300">
            {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
        </div>
    @endif
</a>