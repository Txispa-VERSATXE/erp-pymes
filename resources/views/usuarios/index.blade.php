@extends('layouts.app')

@section('title', 'Administración')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <div style="font-size:11px;font-weight:600;color:#9e9d99;text-transform:uppercase;letter-spacing:0.4px;">Usuarios activos</div>
            <div style="font-size:26px;font-weight:700;letter-spacing:-0.5px;">{{ $usuarios->count() }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <div style="font-size:11px;font-weight:600;color:#9e9d99;text-transform:uppercase;letter-spacing:0.4px;">Administradores</div>
            <div style="font-size:26px;font-weight:700;letter-spacing:-0.5px;">{{ $usuarios->where('rol', 'admin')->count() }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-size:14px;font-weight:600;margin:0;">Gestión de usuarios</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
            <i class="bi bi-plus-lg me-1"></i>Nuevo usuario
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Nombre</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Email</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Rol</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Alta</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td>
                        <div style="font-weight:500;">
                            {{ $usuario->nombre }}
                            @if($usuario->id === auth()->id())
                            <span class="badge" style="background:#dbeafe;color:#1e40af;margin-left:6px;">Tú</span>
                            @endif
                        </div>
                    </td>
                    <td style="color:#6b6a66;">{{ $usuario->email }}</td>
                    <td>
                        <span class="badge {{ $usuario->rol === 'admin' ? 'badge-admin' : 'badge-empleado' }}">
                            {{ $usuario->rol }}
                        </span>
                    </td>
                    <td style="color:#9e9d99;font-size:12px;">{{ $usuario->created_at?->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($usuario->id !== auth()->id())
                            <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}" onsubmit="return confirm('¿Eliminar usuario?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" style="border-radius:6px;padding:3px 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-5">Sin usuarios registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection