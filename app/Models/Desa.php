<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';
    protected $primaryKey = 'id_desa';

    protected $fillable = [
        'nama_desa',
        'kecamatan_id'
    ];

    /**
     * Relasi: Satu Desa dimiliki oleh satu Kecamatan
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'desa_id', 'id_desa');
    }
}