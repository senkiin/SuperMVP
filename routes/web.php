<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManageCategories;
use App\Livewire\User\ManageDocuments;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/documents', ManageDocuments::class)->name('user.documents');
});

// --- GRUPO DE RUTAS DE ADMINISTRADOR ---
// Este bloque define la ruta que te está faltando.
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is_admin' // Nuestro middleware de protección
])->group(function () {
    Route::get('/admin/categories', ManageCategories::class)->name('admin.categories');
    
});
