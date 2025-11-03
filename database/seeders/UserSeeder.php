<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Sri Mulayani',
            'nik' => '1234567890123456',
            'password' => Hash::make('User123'),
            'role' => 'warga',
            'alamat' => 'Jl. Merpati No. 10, Jakarta',
        ]);
    }
}
