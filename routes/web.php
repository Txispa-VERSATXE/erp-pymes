<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\UsuarioController;

// ── Autenticación ──────────────────────────────────────────
Route::get('/',      [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Rutas protegidas (requieren login) ─────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clientes
    Route::resource('clientes', ClienteController::class);

    // Productos
    Route::resource('productos', ProductoController::class);

    // Ventas
    Route::resource('ventas', VentaController::class);

    // Compras
    Route::resource('compras', CompraController::class);

    // Inventario
    Route::get('/inventario',           [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/inventario/{id}',      [InventarioController::class, 'update'])->name('inventario.update');

    // Usuarios (solo admin)
    Route::resource('usuarios', UsuarioController::class);

});