<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $roles = Role::all();

        $users = User::with(['role', 'desa.kecamatan'])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                        ->orWhere('username', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->role_id, function ($query) use ($request) {
                $query->where('role_id', $request->role_id);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin-data.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $kecamatans = Kecamatan::all();

        return view('admin-data.users.create', compact('roles', 'kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id_role'],
            'desa_id' => ['required', 'exists:desa,id_desa'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'jalan' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'desa_id' => $request->desa_id,
            'jalan' => $request->jalan,
            'no_telepon' => $request->no_telepon,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'status' => $request->status,
        ]);

        if ($user->role->nama_role == 'warga') {
            $user->saldo()->create(['jumlah_saldo' => 0]);
        }

        return redirect()->route('admin-data.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function getDesa(Request $request)
    {
        $desa = Desa::where('kecamatan_id', $request->kecamatan_id)
            ->orderBy('nama_desa', 'asc')
            ->get();
        return response()->json($desa);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('desa.kecamatan');

        $roles = Role::all();
        $kecamatans = Kecamatan::all();
        $desas = Desa::where('kecamatan_id', $user->desa->kecamatan_id)->get();

        return view('admin-data.users.edit', compact('user', 'roles', 'kecamatans', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username,' . $user->id_user . ',id_user'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id_role'],
            'desa_id' => ['required', 'exists:desa,id_desa'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'jalan' => ['required', 'string', 'max:255'],
        ]);

        $data = $request->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin-data.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['status' => 'tidak_aktif']);

        return redirect()->route('admin-data.users.index')
            ->with('success', 'User berhasil dinonaktifkan.');
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:8',
        ], [
            'new_password.required' => 'Password baru wajib diisi!',
            'new_password.min' => 'Password minimal 8 karakter!',
        ]);

        $user = User::where('id_user', $id)->firstOrFail();

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil direset menjadi: ' . $request->new_password);
    }
}
