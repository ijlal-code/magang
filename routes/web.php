<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');
Route::post('/submit-doc', [PortalController::class, 'storeDocumentation'])->name('submit.doc');
Route::post('/submit-project', [PortalController::class, 'storeProject'])->name('submit.project');

// Rute Rahasia Admin
Route::get('/rahasia-admin', [PortalController::class, 'adminLoginView'])->name('admin.login');
Route::post('/admin-login', [PortalController::class, 'adminLogin'])->name('admin.auth');
Route::get('/admin-dashboard', [PortalController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/approve/{type}/{id}', [PortalController::class, 'approve'])->name('admin.approve');