<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman beranda utama (Dashboard Home).
     */
    public function home()
    {
        // Mengambil semua data kelas dari database MySQL
        $classes = ClassRoom::all();

        return view('pages.dashboard-home', compact('classes'));
    }

    /**
     * Menampilkan halaman daftar tugas global mahasiswa (Tugas Saya).
     */
    public function allTasks()
    {
        // Memisahkan data tugas berdasarkan status progresnya
        $assignedTasks = Task::where('status', 'assigned')->with('classRoom')->get();
        $completedTasks = Task::where('status', 'completed')->with('classRoom')->get();

        return view('pages.tugas-saya', compact('assignedTasks', 'completedTasks'));
    }
}
