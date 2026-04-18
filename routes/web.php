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
use App\Http\Controllers\ProveedorController;

// ── Autenticación ──────────────────────────────────────────
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Rutas para usuarios autenticados ───────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clientes',   ClienteController::class);
    Route::resource('productos',  ProductoController::class);
    Route::resource('ventas',     VentaController::class);
    Route::resource('compras',    CompraController::class);
    Route::resource('proveedores', ProveedorController::class);

    Route::get('/inventario',           [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/inventario/{id}',      [InventarioController::class, 'update'])->name('inventario.update');

    // ── Solo administradores ───────────────────────────────
    Route::middleware(['rol:admin'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });
});