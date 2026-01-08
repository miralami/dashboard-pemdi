<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AuthController;

Route::get('/', [InstitutionController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// API routes for institution selection
Route::get('/api/institutions', [InstitutionController::class, 'getInstitutions']);
Route::get('/api/categories', [InstitutionController::class, 'getCategories']);

// API routes for region filters and real-time search
Route::get('/api/provinces', [InstitutionController::class, 'getProvinces']);
Route::get('/api/regions/kabkota/{provinceId}', [InstitutionController::class, 'getKabKota']);
Route::get('/api/regions/kecamatan/{kabkotaId}', [InstitutionController::class, 'getKecamatan']);
Route::get('/api/search-institutions', [InstitutionController::class, 'searchInstitutions']);
