<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/styles.css', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    $css = preg_replace('/^\s*@import.*$/m', '', $css);
    $css = preg_replace('/^\s*@source.*$/m', '', $css);
    $css = preg_replace('/^\s*@theme\s*\{\s*/', '', $css);
    $css = preg_replace('/\}\s*$/', '', $css);

    return response($css, 200)
        ->header('Content-Type', 'text/css');
});

// Páginas estáticas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/loja', [HomeController::class, 'loja'])->name('loja');

// Painéis com dados do banco
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// API de Usuários (CRUD)
Route::prefix('api')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

    // Cuidadores de um usuário
    Route::post('/usuarios/{usuarioId}/cuidadores', [UsuarioController::class, 'storeCuidador']);
    Route::delete('/usuarios/{usuarioId}/cuidadores/{cuidadorId}', [UsuarioController::class, 'destroyCuidador']);
});
