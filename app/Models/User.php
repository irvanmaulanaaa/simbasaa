<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'role_id',
        'desa_id',
        'nama_lengkap',
        'username',
        'password',
        'profile_photo_path',
        'no_telepon',
        'jalan',
        'rt',
        'rw',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi: Satu User memiliki satu Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id_role');
    }

    /**
     * Relasi: Satu User memiliki satu Desa
     */
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id', 'id_desa');
    }

    /**
     * Relasi: Satu User (Warga) memiliki satu Saldo
     */
    public function saldo()
    {
        return $this->hasOne(Saldo::class, 'user_id', 'id_user');
    }

    public function setoran()
    {
        return $this->hasMany(Setoran::class, 'warga_id', 'id_user');
    }

    public function hasRole($roleName)
    {
        if ($this->role) {
            return strtolower($this->role->nama_role) === strtolower($roleName);
        }
        
        return false;
    }
}
