<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $classes = ClassRoom::with('instructor')->get();
        } else {
            // Gabungkan kelas yang dia buat dan kelas yang dia ikuti
            $classes = ClassRoom::where('instructor_id', $user->id)
                ->orWhereHas('students', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->with('instructor')->get();
        }

        return view('pages.dashboard-home', compact('classes'));
    }

    public function allTasks()
{
    $user = auth()->user();
    if (!$user) {
        return redirect('/login');
    }

    // Tab 1: Ditugaskan (Tugas dari kelas si murid, yang BELUM dia kumpulkan)
    $assignedTasks = Task::whereHas('classRoom.students', function($q) use ($user) {
        $q->where('users.id', $user->id);
    })->whereDoesntHave('submissions', function($q) use ($user) {
        $q->where('user_id', $user->id);
    })->with('classRoom')->orderBy('deadline', 'asc')->get();

    // Tab 2: Selesai (Tugas dari kelas si murid, yang SUDAH dia kumpulkan)
    // Kita panggil sekalian relasi submissions milik dirinya untuk menampilkan nilai di view
    $completedTasks = Task::whereHas('classRoom.students', function($q) use ($user) {
        $q->where('users.id', $user->id);
    })->whereHas('submissions', function($q) use ($user) {
        $q->where('user_id', $user->id);
    })->with(['classRoom', 'submissions' => function($q) use ($user) {
        $q->where('user_id', $user->id);
    }])->orderBy('deadline', 'desc')->get();

    return view('pages.tugas-saya', compact('assignedTasks', 'completedTasks'));
}
}
