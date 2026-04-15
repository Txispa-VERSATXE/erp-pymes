<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ERP PYMES — @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f4f0; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 240px; min-height: 100vh; background: #1a3a5c;
            position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
        }
        .sidebar-logo { padding: 24px 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-logo h1 { font-size: 17px; font-weight: 700; color: #fff; margin: 0; }
        .sidebar-logo p { font-size: 11px; color: rgba(255,255,255,0.45); margin: 0; }
        .sidebar-user { padding: 14px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0; }
        .sidebar-nav { flex: 1; padding: 12px 0; }
        .nav-section-label { font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.3); letter-spacing: 0.8px; text-transform: uppercase; padding: 8px 20px 4px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 20px; cursor: pointer; color: rgba(255,255,255,0.6); font-size: 13.5px; font-weight: 500; text-decoration: none; border-left: 3px solid transparent; transition: all 0.15s; }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-item.active { color: #fff; background: rgba(255,255,255,0.1); border-left-color: #60a5fa; }
        .sidebar-footer { padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.08); }
        .main-content { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid rgba(0,0,0,0.08); padding: 0 28px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .content { padding: 24px 28px; flex: 1; }
        .card { border: 1px solid rgba(0,0,0,0.08); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .badge-admin { background: #dbeafe; color: #1e40af; }
        .badge-empleado { background: #f1f0ec; color: #6b6a66; }
        .alert-stock { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; border-radius: 8px; padding: 10px 16px; font-size: 13px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo">
        <h1><i class="bi bi-grid-3x3-gap-fill me-2"></i>ERP PYMES</h1>
        <p>Sistema de gestión empresarial</p>
    </div>
    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}</div>
        <div>
            <div style="font-size:13px;font-weight:500;color:#fff;">{{ auth()->user()->nombre }}</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.45);">{{ auth()->user()->rol }}</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-label">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="nav-section-label">Gestión</div>
        <a href="{{ route('clientes.index') }}" class="nav-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Clientes
        </a>
        <a href="{{ route('productos.index') }}" class="nav-item {{ request()->routeIs('productos.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Productos
        </a>
        <a href="{{ route('ventas.index') }}" class="nav-item {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
            <i class="bi bi-cart3"></i> Ventas
        </a>
        <a href="{{ route('compras.index') }}" class="nav-item {{ request()->routeIs('compras.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Compras
        </a>
        <a href="{{ route('inventario.index') }}" class="nav-item {{ request()->routeIs('inventario.*') ? 'active' : '' }}">
            <i class="bi bi-archive"></i> Inventario
        </a>
        @if(auth()->user()->rol === 'admin')
        <div class="nav-section-label">Sistema</div>
        <a href="{{ route('usuarios.index') }}" class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i> Administración
        </a>
        @endif
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item w-100 border-0 bg-transparent text-start">
                <i class="bi bi-box-arrow-left"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <span class="topbar-title">@yield('title', 'Dashboard')</span>
        <span style="font-size:12px;color:#9e9d99;">{{ now()->format('d/m/Y') }}</span>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>