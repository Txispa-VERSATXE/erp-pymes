@extends('layouts.app')

@section('title', 'Detalle cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">{{ $cliente->nombre }}</h2>
                <div class="d-flex gap-2">
                    @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                    @endif
                    <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="padding:12px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Email</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $cliente->email }}</div>
                        </div>
                        <div style="padding:12px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Teléfono</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $cliente->telefono ?? '—' }}</div>
                        </div>
                        <div style="padding:12px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Dirección</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $cliente->direccion ?? '—' }}</div>
                        </div>
                        <div style="padding:12px 0;">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Fecha de alta</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $cliente->created_at?->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 style="font-size:13px;font-weight:600;color:#6b6a66;margin-bottom:12px;">Historial de ventas</h6>
                        @forelse($cliente->ventas as $venta)
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;justify-content:space-between;align-items:center;">
                            <div>
                                <div style="font-size:13px;font-weight:500;">#{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-size:11px;color:#9e9d99;">{{ $venta->fecha_venta }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-weight:600;">{{ number_format($venta->total, 2, ',', '.') }} €</span>
                                <span class="badge rounded-pill
                                    @if($venta->estado === 'pagado') bg-success
                                    @elseif($venta->estado === 'cancelado') bg-danger
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ $venta->estado }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div style="font-size:13px;color:#9e9d99;">Sin ventas registradas</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection