<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom; // Sesuaikan dengan model kelas Anda
use App\Models\User;
use Illuminate\Http\Request;

class AdminClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with('instructor');

        if ($request->has('search')) {
            // Kolom tabel classes adalah 'name'
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $classes = $query->latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function show($id)
    {
        $kelas = ClassRoom::with(['instructor', 'students'])->findOrFail($id);
        // Mengambil user dengan role 'user' (murid)
        $allUsers = User::where('role', 'user')->get();
        return view('admin.classes.show', compact('kelas', 'allUsers'));
    }

    public function removeMember($id, $userId)
    {
        $kelas = ClassRoom::findOrFail($id);
        $kelas->students()->detach($userId);
        return back()->with('success', 'Siswa berhasil dihapus.');
    }
    public function destroy($id)
    {
        $kelas = \App\Models\ClassRoom::findOrFail($id);
        $kelas->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
