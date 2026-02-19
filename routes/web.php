<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// ... (Route publik index, docs, projects, auth, upload TETAP SAMA) ...
Route::get('/', [PortalController::class, 'index'])->name('home');
Route::get('/dokumentasi', [PortalController::class, 'allDocumentation'])->name('docs.index');
Route::get('/projek', [PortalController::class, 'allProjects'])->name('projects.index');
Route::post('/login', [PortalController::class, 'login'])->name('login');
Route::post('/register', [PortalController::class, 'register'])->name('register');
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');
Route::post('/doc/store', [PortalController::class, 'storeDoc'])->name('doc.store');
Route::post('/project/store', [PortalController::class, 'storeProject'])->name('project.store');

// === PROTECTED ROUTES (Admin & User) ===
Route::middleware(['auth'])->group(function() {
    
    // CRUD Update/Delete (Tetap Sama)
    Route::put('/doc/update/{id}', [PortalController::class, 'updateDoc'])->name('doc.update');
    Route::delete('/doc/delete/{id}', [PortalController::class, 'deleteDoc'])->name('doc.delete');
    Route::put('/project/update/{id}', [PortalController::class, 'updateProject'])->name('project.update');
    Route::delete('/project/delete/{id}', [PortalController::class, 'deleteProject'])->name('project.delete');

    // === ADMIN AREA ===
    Route::get('/admin/manage-items', [App\Http\Controllers\PortalController::class, 'adminManageItems'])->name('admin.manage.items');
Route::post('/admin/toggle-pin/{type}/{id}', [App\Http\Controllers\PortalController::class, 'togglePin'])->name('admin.toggle.pin');
    // 1. Dashboard Utama & Settings (BARU)
    Route::get('/admin/dashboard', [PortalController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/admin/settings/update', [PortalController::class, 'updateSettings'])->name('admin.settings.update');

    // 2. List Approval Khusus Anonim (BARU)
    Route::get('/admin/anon-pending', [PortalController::class, 'adminAnonPending'])->name('admin.anon.pending');

    // 3. Manajemen User (Existing)
    Route::get('/admin/users', [PortalController::class, 'adminUsers'])->name('admin.users');
    Route::post('/admin/users/bulk', [PortalController::class, 'bulkUserAction'])->name('admin.users.bulk');

    // 4. General Utilities (Existing)
    Route::get('/approve/{type}/{id}', [PortalController::class, 'approveItem'])->name('admin.approve');
    Route::delete('/user/delete/{id}', [PortalController::class, 'deleteUser'])->name('admin.deleteUser');
});