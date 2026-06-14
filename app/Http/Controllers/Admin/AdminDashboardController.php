<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassRoom; // Sesuaikan dengan model kelas Anda

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_classes' => ClassRoom::count(),
            'total_pengajar' => User::whereHas('managedClasses')->count(), // User yang jadi instruktur
            'total_siswa' => User::where('role', 'user')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
