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

        /* ── Sidebar ── */
        .sidebar {
            width: 240px; min-height: 100vh; background: #1a3a5c;
            position: fixed; top: 0; left: 0; z-index: 1040;
            display: flex; flex-direction: column;
            transition: transform 0.25s ease;
        }
        .sidebar-logo { padding: 24px 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-logo h1 { font-size: 17px; font-weight: 700; color: #fff; margin: 0; }
        .sidebar-logo p { font-size: 11px; color: rgba(255,255,255,0.45); margin: 0; }
        .sidebar-user { padding: 14px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.08); transition: background 0.15s; }
        .sidebar-user:hover { background: rgba(255,255,255,0.06); }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0; }
        .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; }
        .nav-section-label { font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.3); letter-spacing: 0.8px; text-transform: uppercase; padding: 8px 20px 4px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 20px; cursor: pointer; color: rgba(255,255,255,0.6); font-size: 13.5px; font-weight: 500; text-decoration: none; border-left: 3px solid transparent; transition: all 0.15s; }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-item.active { color: #fff; background: rgba(255,255,255,0.1); border-left-color: #60a5fa; }
        .sidebar-footer { padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.08); }

        /* ── Overlay (móvil) ── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1039;
        }
        .sidebar-overlay.active { display: block; }

        /* ── Main content ── */
        .main-content { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Topbar ── */
        .topbar { background: #fff; border-bottom: 1px solid rgba(0,0,0,0.08); padding: 0 28px; height: 56px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .btn-hamburger { display: none; background: none; border: none; font-size: 22px; color: #1a3a5c; padding: 0; line-height: 1; cursor: pointer; margin-right: 12px; }

        .content { padding: 24px 28px; flex: 1; }
        .card { border: 1px solid rgba(0,0,0,0.08); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .badge-admin { background: #dbeafe; color: #1e40af; }
        .badge-empleado { background: #f1f0ec; color: #6b6a66; }
        .alert-stock { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; border-radius: 8px; padding: 10px 16px; font-size: 13px; }

        /* ── Toast notifications ── */
        .toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
        .toast-erp { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 500; min-width: 280px; max-width: 380px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); animation: slideIn 0.3s ease; }
        .toast-erp.toast-success { background: #fff; border-left: 4px solid #16a34a; color: #1a1916; }
        .toast-erp.toast-error   { background: #fff; border-left: 4px solid #dc2626; color: #1a1916; }
        .toast-erp.toast-warning { background: #fff; border-left: 4px solid #f59e0b; color: #1a1916; }
        .toast-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 15px; }
        .toast-success .toast-icon { background: #dcfce7; color: #16a34a; }
        .toast-error .toast-icon   { background: #fee2e2; color: #dc2626; }
        .toast-warning .toast-icon { background: #fef3c7; color: #f59e0b; }
        .toast-close { margin-left: auto; background: none; border: none; color: #9e9d99; cursor: pointer; font-size: 16px; padding: 0; line-height: 1; }
        .toast-close:hover { color: #1a1916; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; border-radius: 0 0 10px 10px; animation: progress 4s linear forwards; }
        .toast-success .toast-progress { background: #16a34a; }
        .toast-error .toast-progress   { background: #dc2626; }
        .toast-warning .toast-progress { background: #f59e0b; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
        @keyframes progress { from { width: 100%; } to { width: 0%; } }

        /* ── RESPONSIVE ── */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .btn-hamburger { display: block; }
            .topbar { padding: 0 16px; }
            .content { padding: 16px; }
            .table-responsive { font-size: 13px; }
            .toast-erp { min-width: 240px; max-width: calc(100vw - 32px); font-size: 13px; }
            .toast-container { bottom: 16px; right: 16px; left: 16px; }
        }

        @media (max-width: 575.98px) {
            .content { padding: 12px; }
            .topbar-title { font-size: 14px; }
            .card-body { padding: 12px; }
            .btn-sm { padding: 3px 8px; font-size: 12px; }
        }
    </style>
</head>
<body>

{{-- Overlay para cerrar sidebar en móvil --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/wildstack.png') }}" alt="WildStack" style="height:40px;width:auto;filter:brightness(0) invert(1);">
        <p style="margin-top:6px;">Sistema de gestión empresarial</p>
    </div>
    <a href="{{ route('perfil.index') }}" class="sidebar-user" style="text-decoration:none;">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}</div>
        <div>
            <div style="font-size:13px;font-weight:500;color:#fff;">{{ auth()->user()->nombre }}</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.45);">{{ auth()->user()->rol }}</div>
        </div>
        <i class="bi bi-chevron-right" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:11px;"></i>
    </a>
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
        <a href="{{ route('proveedores.index') }}" class="nav-item {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Proveedores
        </a>
        <a href="{{ route('inventario.index') }}" class="nav-item {{ request()->routeIs('inventario.*') ? 'active' : '' }}">
            <i class="bi bi-archive"></i> Inventario
        </a>
        @if(in_array(auth()->user()->rol, ['admin', 'masteradmin']))
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
        <div class="d-flex align-items-center">
            <button class="btn-hamburger" id="btnHamburger" onclick="toggleSidebar()" aria-label="Menú">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('title', 'Dashboard')</span>
        </div>
        <span style="font-size:12px;color:#9e9d99;">{{ now()->format('d/m/Y') }}</span>
    </div>
    <div class="content">
        @yield('content')
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('success', '{{ session('success') }}');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('error', '{{ session('error') }}');
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('warning', '{{ session('warning') }}');
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSidebar();
});

document.querySelectorAll('.nav-item').forEach(function(item) {
    item.addEventListener('click', function() {
        if (window.innerWidth < 992) closeSidebar();
    });
});

function showToast(type, message) {
    const icons = { success: 'bi-check-lg', error: 'bi-exclamation-lg', warning: 'bi-exclamation-triangle' };
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast-erp toast-${type}`;
    toast.style.position = 'relative';
    toast.style.overflow = 'hidden';
    toast.innerHTML = `
        <div class="toast-icon"><i class="bi ${icons[type]}"></i></div>
        <span style="flex:1;">${message}</span>
        <button class="toast-close" onclick="removeToast(this.parentElement)"><i class="bi bi-x"></i></button>
        <div class="toast-progress"></div>
    `;
    container.appendChild(toast);
    setTimeout(() => removeToast(toast), 4000);
}

function removeToast(toast) {
    toast.style.animation = 'slideOut 0.3s ease forwards';
    setTimeout(() => toast.remove(), 300);
}
</script>
@yield('scripts')
</body>
</html>