<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    use HasFactory;
    protected $table = 'penarikan';
    protected $primaryKey = 'id_tarik';

    protected $fillable = [
        'warga_id',
        'ketua_id',
        'jumlah',
        'status',
        'tgl_request',
        'tgl_konfirmasi',
        'catatan_ketua',
    ];

    public function warga()
    {
        return $this->belongsTo(User::class, 'warga_id', 'id_user');
    }

    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_id', 'id_user');
    }
}