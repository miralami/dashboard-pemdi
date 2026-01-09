<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AuthController;

// Public routes
Route::get('/', [InstitutionController::class, 'index'])->name('home');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// API routes for institution selection
Route::get('/api/institutions', [InstitutionController::class, 'getInstitutions']);
Route::get('/api/categories', [InstitutionController::class, 'getCategories']);

// API routes for region filters and real-time search
Route::get('/api/provinces', [InstitutionController::class, 'getProvinces']);
Route::get('/api/regions/kabkota/{provinceId}', [InstitutionController::class, 'getKabKota']);
Route::get('/api/regions/kecamatan/{kabkotaId}', [InstitutionController::class, 'getKecamatan']);
Route::get('/api/search-institutions', [InstitutionController::class, 'searchInstitutions']);
