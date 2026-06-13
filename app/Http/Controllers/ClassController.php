<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Menyimpan ruang kelas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'study_program' => 'nullable|string|max:255',
            'instructor_name' => 'required|string|max:255',
        ]);

        // Kumpulan variasi warna gradient background card ala figma
        $gradients = [
            'from-blue-600 to-blue-700',
            'from-indigo-600 to-indigo-700',
            'from-purple-600 to-purple-700',
            'from-emerald-600 to-emerald-700'
        ];

        // Memilih warna secara acak agar visual card bervariasi
        $validated['banner_gradient'] = $gradients[array_rand($gradients)];

        ClassRoom::create($validated);

        return redirect()->back()->with('success', 'Kelas baru berhasil dibuat!');
    }

    /**
     * Menampilkan halaman detail internal ruang kelas (Forum & Tugas Kelas).
     */
    public function show($id)
    {
        // Eager loading relasi untuk mengoptimalkan query database (menghindari N+1 problem)
        $class = ClassRoom::with(['announcements', 'tasks'])->findOrFail($id);

        return view('pages.detail-kelas', compact('class'));
    }
}
