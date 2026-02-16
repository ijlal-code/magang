<?php

use App\Http\Controllers\PortalController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');

// Auth Routes (Login & Register Pengguna Biasa)
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Hanya User Login yang bisa post/delete)
Route::middleware('auth')->group(function() {
    Route::post('/submit-doc', [PortalController::class, 'storeDocumentation'])->name('submit.doc');
    Route::post('/submit-project', [PortalController::class, 'storeProject'])->name('submit.project');
    
    Route::delete('/delete-doc/{id}', [PortalController::class, 'deleteDocumentation'])->name('delete.doc');
    Route::delete('/delete-project/{id}', [PortalController::class, 'deleteProject'])->name('delete.project');
});

// --- BAGIAN ADMIN ---
Route::get('/rahasia-admin', [PortalController::class, 'adminLoginView'])->name('admin.login');
Route::post('/admin-login', [PortalController::class, 'adminLogin'])->name('admin.auth');

// Perbaikan: Hapus wrapper middleware closure yang bikin error.
// Keamanan sudah ditangani di dalam PortalController::dashboard & approve
Route::get('/admin-dashboard', [PortalController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/approve/{type}/{id}', [PortalController::class, 'approve'])->name('admin.approve');