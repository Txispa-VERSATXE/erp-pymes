@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Datos personales --}}
        <div class="card mb-4">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;gap:14px;">
                <div style="width:48px;height:48px;border-radius:50%;background:#1a3a5c;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;">
                    {{ strtoupper(substr($usuario->nombre, 0, 2)) }}
                </div>
                <div>
                    <h2 style="font-size:15px;font-weight:600;margin:0;">{{ $usuario->nombre }}</h2>
                    <span class="badge {{ $usuario->rol === 'admin' ? 'badge-admin' : 'badge-empleado' }}">{{ $usuario->rol }}</span>
                </div>
            </div>
            <div class="card-body p-4">
                @if($errors->has('nombre') || $errors->has('email'))
                <div class="alert alert-danger" style="font-size:13px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('perfil.update') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Nombre completo *</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                                <i class="bi bi-floppy me-1"></i>Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);">
                <h2 style="font-size:14px;font-weight:600;margin:0;">Cambiar contraseña</h2>
            </div>
            <div class="card-body p-4">
                @if($errors->has('password_actual') || $errors->has('password'))
                <div class="alert alert-danger" style="font-size:13px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('perfil.password') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Contraseña actual *</label>
                            <input type="password" name="password_actual" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Nueva contraseña *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Confirmar contraseña *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                                <i class="bi bi-lock me-1"></i>Cambiar contraseña
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection