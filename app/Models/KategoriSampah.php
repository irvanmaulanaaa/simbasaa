<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSampah extends Model
{
    use HasFactory;
    protected $table = 'kategori_sampah';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];

    public function sampah()
    {
        return $this->hasMany(Sampah::class, 'kategori_id', 'id_kategori');
    }
}
