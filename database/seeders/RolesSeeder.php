<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['nama_role' => 'admin_data', 'deskripsi' => 'Bertugas mengelola data master sampah dan konten edukasi']);
        Role::create(['nama_role' => 'admin_pusat', 'deskripsi' => 'Bertugas mengelola harga sampah dan jadwal penimbangan']);
        Role::create(['nama_role' => 'ketua', 'deskripsi' => 'Bertugas mencatat setoran dan mengkonfirmasi penarikan warga']);
        Role::create(['nama_role' => 'warga', 'deskripsi' => 'Anggota yang melakukan setoran sampah']);
    }
}