<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriSampah;

class KategoriSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriSampah::create(['nama_kategori' => 'Plastik']);
        KategoriSampah::create(['nama_kategori' => 'Kertas']);
        KategoriSampah::create(['nama_kategori' => 'Logam']);
        KategoriSampah::create(['nama_kategori' => 'Kaca']);
    }
}