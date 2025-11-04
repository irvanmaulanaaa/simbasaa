<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusKonten;

class StatusKontenSeeder extends Seeder
{
    public function run(): void
    {
        StatusKonten::create(['nama_status' => 'draft']);
        StatusKonten::create(['nama_status' => 'published']);
    }
}