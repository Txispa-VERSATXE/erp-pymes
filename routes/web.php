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
use App\Http\Controllers\PerfilController;

// ── Autenticación ──────────────────────────────────────────
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Rutas para usuarios autenticados ───────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de usuario
    Route::get('/perfil',          [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil',          [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/password', [PerfilController::class, 'password'])->name('perfil.password');

    // ── Exportaciones ──────────────────────────────────────
    Route::get('/clientes/export/excel',    [ClienteController::class,   'exportExcel'])->name('clientes.export.excel');
    Route::get('/clientes/export/pdf',      [ClienteController::class,   'exportPdf'])->name('clientes.export.pdf');
    Route::get('/productos/export/excel',   [ProductoController::class,  'exportExcel'])->name('productos.export.excel');
    Route::get('/productos/export/pdf',     [ProductoController::class,  'exportPdf'])->name('productos.export.pdf');
    Route::get('/ventas/export/excel',      [VentaController::class,     'exportExcel'])->name('ventas.export.excel');
    Route::get('/ventas/export/pdf',        [VentaController::class,     'exportPdf'])->name('ventas.export.pdf');
    Route::get('/compras/export/excel',     [CompraController::class,    'exportExcel'])->name('compras.export.excel');
    Route::get('/compras/export/pdf',       [CompraController::class,    'exportPdf'])->name('compras.export.pdf');
    Route::get('/proveedores/export/excel', [ProveedorController::class, 'exportExcel'])->name('proveedores.export.excel');
    Route::get('/proveedores/export/pdf',   [ProveedorController::class, 'exportPdf'])->name('proveedores.export.pdf');
    Route::get('/inventario/export/excel',  [InventarioController::class,'exportExcel'])->name('inventario.export.excel');
    Route::get('/inventario/export/pdf',    [InventarioController::class,'exportPdf'])->name('inventario.export.pdf');

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