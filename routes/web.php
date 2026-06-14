<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\adminUserController;
use App\Http\Controllers\Admin\AdminClassroomController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubmissionController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/signup', function() {
        return redirect()->route('login')->with('open_signup', true);
    })->name('signup');
    Route::post('/signup', [AuthController::class, 'signup']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'home'])->name('dashboard.home');
    Route::get('/tugas', [DashboardController::class, 'allTasks'])->name('tugas.index');

    Route::post('/classes/join', [ClassController::class, 'join'])->name('classes.join');
    Route::get('/tasks/{task}/review/{student}', [TaskController::class, 'viewStudentSubmission'])->name('tasks.review');

    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');

    Route::post('/classes/{class}/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

    Route::post('/classes/{class}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');

    Route::get('/tasks/{task_id}/submissions/{submission_id}', [TaskController::class, 'showSubmission'])->name('tasks.submissions.show');

    Route::post('/submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');

    Route::post('/tasks/{id}/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen User
    Route::resource('users', AdminUserController::class)->except(['create', 'edit']); // Menggunakan Modal untuk create/edit

    // Manajemen Kelas
    Route::resource('classes', AdminClassroomController::class)->except(['create', 'edit']);
    Route::post('classes/{class}/add-member', [AdminClassroomController::class, 'addMember'])->name('classes.addMember');
    Route::delete('classes/{class}/remove-member/{user}', [AdminClassroomController::class, 'removeMember'])->name('classes.removeMember');
});
