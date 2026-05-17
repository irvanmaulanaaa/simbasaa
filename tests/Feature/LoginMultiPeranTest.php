<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class LoginMultiPeranTest extends TestCase
{
    use DatabaseTransactions; 

    /**
     * Fungsi bantuan untuk membuat pengguna berdasarkan peran (role).
     */
    private function createUserWithRole($roleName)
    {
        $role = Role::firstOrCreate(['nama_role' => $roleName]);
        
        return User::create([
            'role_id' => $role->id_role ?? $role->id, 
            'nama_lengkap' => 'Pengguna Uji ' . $roleName,
            'username' => 'testuser_' . $roleName,
            'password' => bcrypt('password123'),
            'status' => 'aktif'
        ]);
    }

    public function test_warga_login_redirects_to_warga_dashboard(): void
    {
        $user = $this->createUserWithRole('warga');

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('warga.dashboard'));
    }

    public function test_ketua_login_redirects_to_ketua_dashboard(): void
    {
        $user = $this->createUserWithRole('ketua');

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('ketua.dashboard'));
    }

    public function test_admin_pusat_login_redirects_to_admin_pusat_dashboard(): void
    {
        $user = $this->createUserWithRole('admin_pusat');

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin-pusat.dashboard'));
    }

    public function test_admin_data_login_redirects_to_admin_data_dashboard(): void
    {
        $user = $this->createUserWithRole('admin_data');

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin-data.dashboard'));
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = $this->createUserWithRole('warga');

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password_salah',
        ]);

        $this->assertGuest();
        $response->assertInvalid(['username' => 'Username atau password yang Anda masukkan salah.']);
    }

    public function test_login_requires_username_and_password(): void
    {
        $response = $this->post('/login', [
            'username' => '',
            'password' => '',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['username', 'password']);
    }
}