@extends('layouts.app')

@section('title', 'Nuevo cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">Nuevo cliente</h2>
                <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger" style="font-size:13px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('clientes.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Dirección</label>
                            <textarea name="direccion" class="form-control" rows="3">{{ old('direccion') }}</textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                                <i class="bi bi-floppy me-1"></i>Guardar cliente
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection