<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'nama_kecamatan',
        'kab_kota'
    ];

    /**
     * Relasi: Satu Kecamatan memiliki banyak Desa
     */
    public function desas()
    {
        return $this->hasMany(Desa::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Desa::class,
            'kecamatan_id',
            'desa_id',
            'id_kecamatan',
            'id_desa'
        );
    }
}