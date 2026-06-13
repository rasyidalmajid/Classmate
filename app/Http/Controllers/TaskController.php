<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Task;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, ClassRoom $class)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $class->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => 'assigned',
        ]);

        return redirect()->route('classes.show', $class->id)->with('success', 'Tugas baru berhasil dirilis!');
    }

public function show($id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login');
        }

        // Load data tugas beserta relasi kelas, dosen, dan seluruh mahasiswa di kelas tersebut
        $task = Task::with(['classRoom.instructor', 'classRoom.students'])->findOrFail($id);

        // Menentukan role user saat ini
        $isInstructor = $task->classRoom->instructor_id === $user->id;
        $isAdmin = isset($user->role) && $user->role === 'admin';

        // JIKA PENGAJAR / ADMIN: Arahkan ke halaman Daftar Pengumpulan Tugas
        if ($isInstructor || $isAdmin) {
            // Ambil semua submission tugas ini beserta data user muridnya
            $submissions = $task->submissions()->with('user')->get();

            // Cari list ID murid yang sudah mengumpulkan berkas
            $submittedUserIds = $submissions->pluck('user_id')->toArray();

            // Filter mahasiswa yang belum mengumpulkan tugas
            $unsubmittedStudents = $task->classRoom->students->whereNotIn('id', $submittedUserIds);

            return view('pages.pengajar-daftar-pengumpulan', compact('task', 'submissions', 'unsubmittedStudents'));
        }

        // JIKA MURID: Langsung tampilkan halaman detail tugas asli (Formulir Pengumpulan)
        $mySubmission = $task->submissions()->where('user_id', $user->id)->first();

        return view('pages.detail-tugas', compact('task', 'mySubmission'));
    }

    /**
     * Menampilkan detail pengumpulan berkas milik satu murid tertentu (Khusus Pengajar/Admin)
     */
    public function showSubmission($task_id, $submission_id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login');
        }

        $task = Task::with('classRoom')->findOrFail($task_id);

        // Proteksi keamanan / Gatekeeper multi-role
        $isInstructor = $task->classRoom->instructor_id === $user->id;
        $isAdmin = isset($user->role) && $user->role === 'admin';

        if (!$isInstructor && !$isAdmin) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat lembar kerja mahasiswa ini.');
        }

        // Ambil data pengumpulan spesifik milik murid tersebut
        $submission = Submission::with('user')->findOrFail($submission_id);

        return view('pages.pengajar-detail-submission', compact('task', 'submission'));
    }
}
