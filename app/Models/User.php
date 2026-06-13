<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi objek (seperti API/Array conversion).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang otomatis diubah tipe datanya (Casting).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Otomatis mengamankan password dengan Bcrypt di Laravel modern
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Kelas yang dibuat oleh user ini (Sebagai Pengajar)
    public function managedClasses()
    {
        return $this->hasMany(ClassRoom::class, 'instructor_id');
    }

    // Kelas yang diikuti oleh user ini (Sebagai Murid)
    public function joinedClasses()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_user', 'user_id', 'class_id');
    }
}
