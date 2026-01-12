<?php

namespace Database\Seeders;

use App\Models\KategoriKonten;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriKontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Umum'],
            ['nama_kategori' => 'Anak-anak'],
            ['nama_kategori' => 'Remaja'],
            ['nama_kategori' => 'Orang Tua'],
        ];

        foreach ($data as $item) {
            KategoriKonten::firstOrCreate($item);
        }
    }
}