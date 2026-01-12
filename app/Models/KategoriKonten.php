<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKonten extends Model
{
    use HasFactory;

    protected $table = 'kategori_kontens';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];

    public function konten()
    {
        return $this->hasMany(Konten::class, 'id_kategori', 'id_kategori');
    }
}