<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'study_program' => 'nullable|string|max:255',
        ]);

        do {
            $code = Str::random(6);
        } while (ClassRoom::where('code', $code)->exists());

        $gradients = ['from-blue-600 to-indigo-700', 'from-purple-600 to-pink-600', 'from-emerald-500 to-teal-700', 'from-amber-500 to-orange-600'];
        $randomGradient = $gradients[array_rand($gradients)];

        ClassRoom::create([
            'name' => $validated['name'],
            'study_program' => $validated['study_program'],
            'instructor_id' => auth()->id(),
            'code' => $code,
            'banner_gradient' => $randomGradient
        ]);

        return redirect()->route('dashboard.home')->with('success', 'Kelas baru berhasil dibuat!');
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $class = ClassRoom::where('code', $request->code)->first();

        if (!$class) {
            return back()->withErrors(['join_error' => 'Kode kelas tidak ditemukan.']);
        }

        if ($class->instructor_id === auth()->id()) {
            return back()->withErrors(['join_error' => 'Anda adalah pengajar di kelas ini.']);
        }

        // Cek join menggunakan ID mentah untuk menghindari masalah penamaan tabel pivot
        $alreadyJoined = \DB::table('class_user')
                            ->where('class_id', $class->id)
                            ->where('user_id', auth()->id())
                            ->exists();

        if ($alreadyJoined) {
            return back()->withErrors(['join_error' => 'Anda sudah bergabung di kelas ini.']);
        }

        $class->students()->attach(auth()->id());

        return redirect()->route('classes.show', $class->id)->with('success', 'Berhasil bergabung ke kelas!');
    }

    public function show($id)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        $class = ClassRoom::with(['announcements', 'tasks', 'instructor', 'students'])->findOrFail($id);

        $isInstructor = $class->instructor_id === $user->id;

        // Menggunakan query DB mentah untuk mengecek keanggotaan agar terhindar dari ketidakcocokan pivot model
        $isStudent = \DB::table('class_user')
                        ->where('class_id', $class->id)
                        ->where('user_id', $user->id)
                        ->exists();

        // Mengamankan pengecekan admin secara langsung ke string kolom database
        $isAdmin = isset($user->role) && $user->role === 'admin';

        if (!$isInstructor && !$isStudent && !$isAdmin) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        return view('pages.detail-kelas', compact('class', 'isInstructor', 'isAdmin'));
    }
}
