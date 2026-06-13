<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /**
     * Memproses pengiriman tugas oleh mahasiswa (Form Upload)
     */
    public function store(Request $request, $task_id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/login');
        }

        // Validasi input data dari form
        $request->validate([
            'link_url'  => 'nullable|url',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:20480', // Maksimal 20MB
            'notes'     => 'nullable|string',
        ]);

        // Cek apakah mahasiswa ini sudah pernah mengumpulkan tugas ini sebelumnya
        $existingSubmission = Submission::where('task_id', $task_id)
                                        ->where('user_id', $user->id)
                                        ->first();

        if ($existingSubmission) {
            return redirect()->back()->withErrors(['upload_error' => 'Anda sudah mengumpulkan tugas ini sebelumnya.']);
        }

        $uploadedPath = null;

        // Perbaikan Logika Upload File
        if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
            // Menyimpan file ke dalam folder 'storage/app/public/submissions'
            $file = $request->file('file_path');

            // Membuat nama file unik gabungan timestamp dan nama asli berkas
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Simpan berkas
            $uploadedPath = $file->storeAs('submissions', $fileName, 'public');
        }

        // Simpan records ke database
        Submission::create([
            'task_id'   => $task_id,
            'user_id'   => $user->id,
            'link_url'  => $request->link_url,
            'file_path' => $uploadedPath, // Berisi path 'submissions/namafile.ext' jika ada file
            'notes'     => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Tugas Anda berhasil diserahkan dan diarsip!');
    }

    /**
     * Memproses penilaian dan feedback komentar dari Pengajar
     */
    public function grade(Request $request, $id)
    {
        $request->validate([
            'grade'    => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($id);

        // Update nilai beserta feedback pengajar
        $submission->update([
            'grade'    => $request->grade,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('tasks.show', $submission->task_id)
            ->with('success', 'Evaluasi nilai dan feedback berhasil disimpan ke database!');
    }
}
