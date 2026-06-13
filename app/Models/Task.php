<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'deadline',
        'status'
    ];

    /**
     * Konversi tipe data otomatis (Casting).
     * Mengubah string datetime dari MySQL menjadi Objek Carbon.
     * Ini penting agar kita bisa menggunakan method bawaan seperti ->diffForHumans() atau ->translatedFormat().
     */
    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relasi Many-to-One (Belongs To): Sebuah tugas merupakan bagian dari satu kelas tertentu.
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'task_id');
    }

    // Helper untuk mengecek status pengumpulan user yang sedang login
    public function currentUserSubmission()
    {
        return $this->hasOne(Submission::class, 'task_id')->where('user_id', auth()->id());
    }


}
