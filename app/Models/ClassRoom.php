<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database secara eksplisit karena berbeda dengan konvensi jamak (plural) Laravel
    protected $table = 'classes';

    protected $fillable = ['name', 'study_program', 'instructor_id', 'code', 'banner_gradient'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'class_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'class_id');
    }
}
