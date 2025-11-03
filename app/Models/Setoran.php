<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;
    protected $table = 'setoran';
    protected $primaryKey = 'id_setor';

    protected $fillable = ['warga_id', 'ketua_id', 'total_harga', 'tgl_setor'];

    public function warga()
    {
        return $this->belongsTo(User::class, 'warga_id', 'id_user');
    }

    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_id', 'id_user');
    }

    public function detail()
    {
        return $this->hasMany(DetailSetoran::class, 'setor_id', 'id_setor');
    }
}