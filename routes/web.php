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

    // ── Exportaciones ──────────────────────────────────────
    Route::get('/clientes/export/excel', [ClienteController::class, 'exportExcel'])->name('clientes.export.excel');
    Route::get('/clientes/export/pdf',   [ClienteController::class, 'exportPdf'])->name('clientes.export.pdf');
    Route::get('/productos/export/excel',[ProductoController::class, 'exportExcel'])->name('productos.export.excel');
    Route::get('/productos/export/pdf',  [ProductoController::class, 'exportPdf'])->name('productos.export.pdf');
    Route::get('/ventas/export/excel',   [VentaController::class, 'exportExcel'])->name('ventas.export.excel');
    Route::get('/ventas/export/pdf',     [VentaController::class, 'exportPdf'])->name('ventas.export.pdf');

    Route::resource('clientes',    ClienteController::class);
    Route::resource('productos',   ProductoController::class);
    Route::resource('ventas',      VentaController::class);
    Route::resource('compras',     CompraController::class);
    Route::resource('proveedores', ProveedorController::class);

    Route::get('/inventario',           [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/inventario/{id}',      [InventarioController::class, 'update'])->name('inventario.update');

    // ── Solo administradores ───────────────────────────────
    Route::middleware(['rol:admin'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });
});