<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile information.
     */
    public function show(Request $request): View
    {
        $user = $request->user()->load('desa');

        $kecamatans = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();
        $allDesas = Desa::orderBy('nama_desa', 'asc')->get();

        return view('profile.show', [
            'user' => $user,
            'kecamatans' => $kecamatans,
            'allDesas' => $allDesas,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->hasFile('profile_photo')) {
            if ($request->user()->profile_photo_path) {
                Storage::disk('public')->delete($request->user()->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $request->user()->profile_photo_path = $path;
        }

        $request->user()->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Cek ketersediaan username secara realtime via AJAX.
     */
    public function checkUsername(Request $request)
    {
        $request->validate(['username' => 'required|string']);

        $exists = User::where('username', $request->username)
            ->where('id_user', '!=', $request->user()->id_user)
            ->exists();

        return response()->json(['status' => $exists ? 'taken' : 'available']);
    }

    /**
     * Update foto profil saja.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'max:2048'],
        ], [
            'profile_photo.max' => 'Ukuran foto maksimal 2MB',
            'profile_photo.image' => 'File harus berupa gambar',
        ]);

        $user = $request->user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            
            $user->forceFill([
                'profile_photo_path' => $path,
            ])->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus foto profil pengguna.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            
            $user->forceFill([
                'profile_photo_path' => null,
            ])->save();
        }

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
    }
}
