<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_komentar';
    protected $fillable = ['konten_id', 'user_id', 'isi_komentar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}