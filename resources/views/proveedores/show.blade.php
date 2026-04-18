@extends('layouts.app')

@section('title', 'Detalle proveedor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">{{ $proveedor->nombre }}</h2>
                <div class="d-flex gap-2">
                    @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    @endif
                    <a href="{{ route('proveedores.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Email</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $proveedor->email }}</div>
                        </div>
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Teléfono</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $proveedor->telefono ?? '—' }}</div>
                        </div>
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Dirección</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $proveedor->direccion ?? '—' }}</div>
                        </div>
                        <div style="padding:10px 0;">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Fecha de alta</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $proveedor->created_at?->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 style="font-size:13px;font-weight:600;color:#6b6a66;margin-bottom:12px;">Historial de compras</h6>
                        @forelse($compras as $compra)
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;justify-content:space-between;align-items:center;">
                            <div>
                                <div style="font-size:13px;font-weight:500;">#{{ strtoupper(substr($compra->id, -6)) }}</div>
                                <div style="font-size:11px;color:#9e9d99;">{{ $compra->fecha_compra }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-weight:600;">{{ number_format($compra->total, 2, ',', '.') }} €</span>
                                <span class="badge rounded-pill
                                    @if($compra->estado === 'recibido') bg-success
                                    @elseif($compra->estado === 'cancelado') bg-danger
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ $compra->estado }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div style="font-size:13px;color:#9e9d99;">Sin compras registradas</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection