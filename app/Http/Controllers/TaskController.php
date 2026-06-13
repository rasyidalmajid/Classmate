<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function store(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $class->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'status' => 'assigned',
        ]);

        return redirect()->route('classes.show', $class->id)->with('success', 'Tugas baru berhasil dirilis!');
    }

    public function show(Task $task)
    {
        // Muat data kelas beserta data submission milik user yang sedang login
        $task->load(['classRoom', 'currentUserSubmission']);

        return view('pages.detail-tugas', compact('task'));
    }

    public function submit(Request $request, Task $task)
    {
        // Validasi input: File opsional (maks 20MB), Link opsional, tapi salah satu harus diisi
        $request->validate([
            'file_assignment' => 'nullable|file|max:20480',
            'link_url' => 'nullable|url|max:255',
        ], [
            'file_assignment.max' => 'Ukuran berkas terlalu besar, maksimal 20MB.',
            'link_url.url' => 'Format tautan URL tidak valid.'
        ]);

        if (!$request->hasFile('file_assignment') && !$request->filled('link_url')) {
            return back()->withErrors(['error_submission' => 'Harap lampirkan berkas atau masukkan tautan tugas terlebih dahulu.']);
        }

        $filePath = null;

        // Jika user mengunggah file, simpan ke folder storage/app/public/submissions
        if ($request->hasFile('file_assignment')) {
            $file = $request->file('file_assignment');
            $filePath = $file->store('submissions', 'public');
        }

        // Catat data ke tabel submissions
        Submission::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'link_url' => $request->input('link_url'),
        ]);

        // Perbarui status tugas menjadi completed
        $task->update(['status' => 'completed']);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
