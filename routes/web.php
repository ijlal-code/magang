<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');

// === HALAMAN PUBLIK BARU (Search & Pagination) ===
Route::get('/dokumentasi', [PortalController::class, 'allDocumentation'])->name('docs.index');
Route::get('/projek', [PortalController::class, 'allProjects'])->name('projects.index');

// ... (Sisa route AUTH dan UPLOAD biarkan tetap sama seperti sebelumnya) ...
// Route login, register, storeDoc, storeProject, dll jangan dihapus.
Route::post('/login', [PortalController::class, 'login'])->name('login');
Route::post('/register', [PortalController::class, 'register'])->name('register');
Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

Route::post('/doc/store', [PortalController::class, 'storeDoc'])->name('doc.store');
Route::post('/project/store', [PortalController::class, 'storeProject'])->name('project.store');

Route::middleware(['auth'])->group(function() {
    // ... route admin ...
    Route::put('/doc/update/{id}', [PortalController::class, 'updateDoc'])->name('doc.update');
    Route::delete('/doc/delete/{id}', [PortalController::class, 'deleteDoc'])->name('doc.delete');
    
    Route::put('/project/update/{id}', [PortalController::class, 'updateProject'])->name('project.update');
    Route::delete('/project/delete/{id}', [PortalController::class, 'deleteProject'])->name('project.delete');

    Route::get('/admin/users', [PortalController::class, 'adminUsers'])->name('admin.users');
    Route::post('/admin/users/bulk', [PortalController::class, 'bulkUserAction'])->name('admin.users.bulk');
    Route::get('/approve/{type}/{id}', [PortalController::class, 'approveItem'])->name('admin.approve');
    Route::delete('/user/delete/{id}', [PortalController::class, 'deleteUser'])->name('admin.deleteUser');
});