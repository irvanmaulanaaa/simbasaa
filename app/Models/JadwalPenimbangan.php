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
        'user_id', 'desa_id', 'rw_penimbangan', 'jam_penimbangan', 'tgl_jadwal'
    ];
}