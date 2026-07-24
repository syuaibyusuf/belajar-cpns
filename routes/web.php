<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PackageController;
use App\Http\Controllers\Web\TryoutController as UserTryoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\TryoutController as AdminTryoutController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\BackupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/materi', [DashboardController::class, 'materiIndex'])->name('materi.index');
Route::get('/materi/kategori/{category}', [DashboardController::class, 'materiByCategory'])->name('materi.by-category');
Route::get('/materi/{id}', [DashboardController::class, 'materiDetail'])->name('materi.detail');
Route::get('/latihan', [DashboardController::class, 'latihan'])->name('latihan');

// Routes untuk paket soal
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{id}/start', [PackageController::class, 'start'])->name('packages.start');
Route::post('/packages/{id}/submit', [PackageController::class, 'submit'])->name('packages.submit');

// Routes untuk try out
Route::get('/tryouts', [UserTryoutController::class, 'index'])->name('tryouts.index');
Route::get('/tryouts/{id}/start', [UserTryoutController::class, 'start'])->name('tryouts.start');
Route::post('/tryouts/{id}/submit', [UserTryoutController::class, 'submit'])->name('tryouts.submit');

// Routes untuk Saran & Masukan
Route::get('/saran', [DashboardController::class, 'feedbackPage'])->name('feedback.page');
Route::post('/saran', [DashboardController::class, 'storeFeedback'])->name('feedback.store');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Protected routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Materi
        Route::resource('materi', MateriController::class);
        Route::post('/materi/{id}/toggle-status', [MateriController::class, 'toggleStatus'])->name('materi.toggle');
        
        // Manajemen Soal
        Route::resource('soal', SoalController::class);
        Route::get('/soal/export/template', [SoalController::class, 'downloadTemplate'])->name('soal.template');
        Route::get('/soal/export', [SoalController::class, 'export'])->name('soal.export');
        
        // Manajemen Paket Soal
        Route::resource('packages', AdminPackageController::class);
        Route::get('/packages/{id}/edit-questions', [AdminPackageController::class, 'editQuestions'])->name('packages.edit-questions');
        Route::post('/packages/{id}/save-questions', [AdminPackageController::class, 'saveQuestions'])->name('packages.save-questions');
        Route::post('/packages/{id}/duplicate', [AdminPackageController::class, 'duplicate'])->name('packages.duplicate');
        
        // Manajemen Try Out
        Route::resource('tryouts', AdminTryoutController::class);
        Route::get('/tryouts/{id}/edit-questions', [AdminTryoutController::class, 'editQuestions'])->name('tryouts.edit-questions');
        Route::post('/tryouts/{id}/save-questions', [AdminTryoutController::class, 'saveQuestions'])->name('tryouts.save-questions');
        Route::post('/tryouts/{id}/duplicate', [AdminTryoutController::class, 'duplicate'])->name('tryouts.duplicate');
        
        // Manajemen Feedback
        Route::resource('feedback', FeedbackController::class);
        Route::post('/feedback/{id}/respond', [FeedbackController::class, 'respond'])->name('feedback.respond');
        
        // ==================== BACKUP DATABASE ROUTES ====================
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup/create', [BackupController::class, 'backup'])->name('backup.create');
        Route::get('/backup/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/delete/{filename}', [BackupController::class, 'delete'])->name('backup.delete');
        Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
    });
});
