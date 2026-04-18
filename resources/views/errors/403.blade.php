@extends('layouts.app')

@section('title', 'Acceso denegado')

@section('content')
<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:60vh;text-align:center;">
    <div style="width:72px;height:72px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
        <i class="bi bi-shield-x" style="font-size:32px;color:#991b1b;"></i>
    </div>
    <h1 style="font-size:48px;font-weight:700;color:#1a1916;letter-spacing:-1px;margin-bottom:8px;">403</h1>
    <h2 style="font-size:18px;font-weight:600;color:#1a1916;margin-bottom:8px;">Acceso no autorizado</h2>
    <p style="font-size:14px;color:#6b6a66;margin-bottom:28px;">No tienes permisos para acceder a esta página.<br>Contacta con el administrador si crees que es un error.</p>
    <a href="{{ route('dashboard') }}" class="btn" style="background:#1a3a5c;color:#fff;border-radius:8px;padding:10px 24px;">
        <i class="bi bi-arrow-left me-2"></i>Volver al dashboard
    </a>
</div>
@endsection