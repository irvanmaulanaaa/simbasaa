<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPenimbangan extends Model
{
    use HasFactory;
    protected $table = 'jadwal_penimbangan';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
        'user_id',
        'desa_id',
        'rw_penimbangan',
        'nama_driver',
        'jam_penimbangan',
        'tgl_jadwal'
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id', 'id_desa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}