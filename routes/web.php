<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');

// ==========================================
// AUTHENTICATION (Login, Register, Logout)
// ==========================================
Route::post('/login', [PortalController::class, 'login'])->name('login');
Route::post('/register', [PortalController::class, 'register'])->name('register');
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

// ==========================================
// USER & ADMIN ROUTES (Perlu Login)
// ==========================================
Route::middleware(['auth'])->group(function() {
    
    // --- Upload & Manage Dokumentasi ---
    Route::post('/doc/store', [PortalController::class, 'storeDoc'])->name('doc.store');
    Route::put('/doc/update/{id}', [PortalController::class, 'updateDoc'])->name('doc.update');
    Route::delete('/doc/delete/{id}', [PortalController::class, 'deleteDoc'])->name('doc.delete');

    // --- Upload & Manage Projek ---
    Route::post('/project/store', [PortalController::class, 'storeProject'])->name('project.store');
    Route::put('/project/update/{id}', [PortalController::class, 'updateProject'])->name('project.update');
    Route::delete('/project/delete/{id}', [PortalController::class, 'deleteProject'])->name('project.delete');

    // --- ADMIN ONLY ACTIONS ---
    // Keamanan admin dijaga di dalam Controller (function approveItem & deleteUser)
    Route::get('/approve/{type}/{id}', [PortalController::class, 'approveItem'])->name('admin.approve');
    Route::delete('/user/delete/{id}', [PortalController::class, 'deleteUser'])->name('admin.deleteUser');
});