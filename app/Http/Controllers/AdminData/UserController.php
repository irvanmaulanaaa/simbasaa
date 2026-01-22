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
            ->when($request->role, function ($query) use ($request) {
                $query->where('role_id', $request->role);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
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
        $kecamatans = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();

        return view('admin-data.users.create', compact('roles', 'kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'username' => strtolower(str_replace(' ', '', $request->username))
        ]);

        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
            'role_id' => ['required', 'exists:roles,id_role'],
            'kecamatan_id' => ['required', 'exists:kecamatan,id_kecamatan'],
            'desa_id' => ['required', 'exists:desa,id_desa'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'jalan' => ['required', 'string', 'max:255'],
        ], [
            'required' => 'Wajib diisi!',
            'role_id.required' => 'Role wajib dipilih!',
            'kecamatan_id.required' => 'Kecamatan wajib dipilih!',
            'desa_id.required' => 'Desa wajib dipilih!',
            'status.required' => 'Status wajib dipilih!',
            'password.min' => 'Password belum 8 karakter (Minimal 8 karakter)',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok dengan password di atas',
            'unique' => 'Username ini sudah terpakai, Gunakan username lain!',
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

        if ($user->role && $user->role->nama_role == 'warga') {
            $user->saldo()->create(['jumlah_saldo' => 0]);
        }

        return redirect()->back()
            ->with('success_create', 'Pengguna berhasil ditambahkan');
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
        $kecamatans = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();
        $desas = Desa::where('kecamatan_id', $user->desa->kecamatan_id)
            ->orderBy('nama_desa', 'asc')
            ->get();
        
        return view('admin-data.users.edit', compact('user', 'roles', 'kecamatans', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->merge([
            'username' => strtolower(str_replace(' ', '', $request->username))
        ]);

        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username,' . $user->id_user . ',id_user'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id_role'],
            'kecamatan_id' => ['required'],
            'desa_id' => ['required', 'exists:desa,id_desa'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'status' => ['required', 'in:aktif,tidak_aktif'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'jalan' => ['required', 'string', 'max:255'],
        ], [
            'required' => 'Wajib diisi!',
            'unique' => 'Username ini sudah terpakai oleh pengguna lain.',
            'confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'in' => 'Pilihan status tidak valid.',
            'exists' => 'Data pilihan tidak valid.'
        ]);

        $data = $request->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()
            ->with('success_update', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->update(['status' => 'tidak_aktif']);

        return redirect()->route('admin-data.users.index')
            ->with('success', 'Pengguna berhasil dinonaktifkan!');
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
