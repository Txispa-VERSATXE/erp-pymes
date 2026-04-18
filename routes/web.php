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
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Rutas para usuarios autenticados ───────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clientes — cualquier usuario autenticado
    Route::resource('clientes', ClienteController::class);

    // Productos — cualquier usuario autenticado
    Route::resource('productos', ProductoController::class);

    // Ventas — cualquier usuario autenticado
    Route::resource('ventas', VentaController::class);

    // Compras — cualquier usuario autenticado
    Route::resource('compras', CompraController::class);

    // Inventario — cualquier usuario autenticado
    Route::get('/inventario',            [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/{id}/edit',  [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/inventario/{id}',       [InventarioController::class, 'update'])->name('inventario.update');

    // ── Rutas solo para administradores ────────────────────
    Route::middleware(['rol:admin'])->group(function () {

        // Gestión de usuarios
        Route::resource('usuarios', UsuarioController::class);

        // Crear/editar/eliminar clientes
        Route::post('clientes',              [ClienteController::class, 'store'])->name('clientes.store.admin');
        Route::put('clientes/{cliente}',     [ClienteController::class, 'update'])->name('clientes.update.admin');
        Route::delete('clientes/{cliente}',  [ClienteController::class, 'destroy'])->name('clientes.destroy.admin');

        // Crear/editar/eliminar productos
        Route::post('productos',             [ProductoController::class, 'store'])->name('productos.store.admin');
        Route::put('productos/{producto}',   [ProductoController::class, 'update'])->name('productos.update.admin');
        Route::delete('productos/{producto}',[ProductoController::class, 'destroy'])->name('productos.destroy.admin');

    });
});