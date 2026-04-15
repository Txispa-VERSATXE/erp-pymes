@extends('layouts.app')

@section('title', 'Editar venta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">
                    Editar venta #{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}
                </h2>
                <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
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
                <form method="POST" action="{{ route('ventas.update', $venta->id) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="pendiente" {{ $venta->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ $venta->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="cancelado" {{ $venta->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                            <i class="bi bi-floppy me-1"></i>Actualizar estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection