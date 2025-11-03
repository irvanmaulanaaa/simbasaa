<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSetoran extends Model
{
    use HasFactory;
    protected $table = 'detail_setoran';
    protected $primaryKey = 'id_detail_setor';

    protected $fillable = ['setor_id', 'sampah_id', 'berat', 'subtotal'];

    public function setoran()
    {
        return $this->belongsTo(Setoran::class, 'setor_id', 'id_setor');
    }

    public function sampah()
    {
        return $this->belongsTo(Sampah::class, 'sampah_id', 'id_sampah');
    }
}