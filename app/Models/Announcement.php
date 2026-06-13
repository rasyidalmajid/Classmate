<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'content'
    ];

    /**
     * Relasi Many-to-One (Belongs To): Sebuah pengumuman merujuk pada satu kelas tertentu.
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
