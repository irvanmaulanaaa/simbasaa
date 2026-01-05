<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Tambahkan ini agar data bisa disimpan
    protected $fillable = [
        'user_id', 
        'id_konten'
    ];
}