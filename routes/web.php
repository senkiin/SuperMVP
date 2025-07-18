<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManageCategories;
use App\Livewire\User\ManageDocuments;
use App\Livewire\CompanyManager;
use App\Livewire\Admin\ManageFormFields;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard que usa la vista blade - NUNCA devolver componentes directamente
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/documents', ManageDocuments::class)->name('user.documents');
    Route::get('/companies', CompanyManager::class)->name('companies.index');
});

// --- GRUPO DE RUTAS DE ADMINISTRADOR ---
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is_admin' // Nuestro middleware de protección
])->group(function () {
    Route::get('/admin/categories', ManageCategories::class)->name('admin.categories');
    Route::get('/admin/form-fields', ManageFormFields::class)->name('admin.form-fields');
});
