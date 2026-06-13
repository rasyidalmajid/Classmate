<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Menyimpan pengumuman baru dari dosen pengampu ke dalam kelas tertentu.
     */
    public function store(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        // Menyimpan data memanfaatkan relasi HasMany dari Model ClassRoom
        $class->announcements()->create([
            'content' => $validated['content']
        ]);

        return redirect()->route('classes.show', $class->id)->with('success', 'Pengumuman berhasil disematkan di forum!');
    }
}
