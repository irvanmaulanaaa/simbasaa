<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminDataRole = Role::where('nama_role', 'admin_data')->first();

        if ($adminDataRole) {
            User::create([
                'nama_lengkap' => 'Admin Data',
                'username' => 'admindata',
                'password' => Hash::make('12345678'),
                'role_id' => $adminDataRole->id_role,
                'desa_id' => null, 
                'status' => 'aktif',
            ]);
        }
        
    }
}
