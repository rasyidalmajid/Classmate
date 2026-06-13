<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database secara eksplisit karena berbeda dengan konvensi jamak (plural) Laravel
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'study_program',
        'instructor_name',
        'banner_gradient'
    ];

    /**
     * Relasi One-to-Many: Sebuah kelas memiliki banyak pengumuman di forum.
     * Mengurutkan pengumuman dari yang paling baru diterbitkan (latest).
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'class_id')->latest();
    }

    /**
     * Relasi One-to-Many: Sebuah kelas memiliki banyak tugas kuliah.
     * Mengurutkan tugas dari yang paling baru ditambahkan.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'class_id')->latest();
    }
}
