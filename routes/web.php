<?php

use App\Http\Controllers\PortalController;
// use App\Http\Controllers\AuthController; // Tidak perlu jika logic ada di PortalController
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');

// ==========================================
// AUTHENTICATION
// ==========================================
Route::post('/login', [PortalController::class, 'login'])->name('login');
Route::post('/register', [PortalController::class, 'register'])->name('register');
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

// ==========================================
// UPLOAD CONTENT (Bisa Login / Anonim)
// ==========================================
// Ditaruh DI LUAR middleware 'auth' agar fitur Anonim tetap jalan.
// Pengecekan login/anonim dilakukan di dalam Controller.
Route::post('/doc/store', [PortalController::class, 'storeDoc'])->name('doc.store');
Route::post('/project/store', [PortalController::class, 'storeProject'])->name('project.store');

// ==========================================
// PROTECTED ROUTES (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function() {
    
    // --- Edit & Delete (User Sendiri / Admin) ---
    Route::put('/doc/update/{id}', [PortalController::class, 'updateDoc'])->name('doc.update');
    Route::delete('/doc/delete/{id}', [PortalController::class, 'deleteDoc'])->name('doc.delete');
    
    Route::put('/project/update/{id}', [PortalController::class, 'updateProject'])->name('project.update');
    Route::delete('/project/delete/{id}', [PortalController::class, 'deleteProject'])->name('project.delete');

    // --- ADMIN MANAGEMENT AREA ---
    // (Keamanan role 'admin' dijaga di dalam Controller)

    // 1. Halaman Kelola User & Search (BARU)
    Route::get('/admin/users', [PortalController::class, 'adminUsers'])->name('admin.users');

    // 2. Aksi Massal/Bulk: Bebaskan, Batasi, Hapus Banyak (BARU)
    Route::post('/admin/users/bulk', [PortalController::class, 'bulkUserAction'])->name('admin.users.bulk');

    // 3. Approval & Utilities
    Route::get('/approve/{type}/{id}', [PortalController::class, 'approveItem'])->name('admin.approve');
    Route::delete('/user/delete/{id}', [PortalController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::post('/user/toggle/{id}', [PortalController::class, 'toggleUserStatus'])->name('admin.toggleUser');
});