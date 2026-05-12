@extends('layouts.app')

@section('title', 'Inventario')

@section('content')

@if($alertas->count() > 0)
<div style="background:#fef3c7;border:1px solid #fde68a;color:#92400e;border-radius:8px;padding:12px 16px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
    <i class="bi bi-exclamation-triangle"></i>
    <div><strong>{{ $alertas->count() }} productos</strong> por debajo del stock mínimo:
    {{ $alertas->pluck('nombre')->join(', ') }}</div>
</div>
@endif

<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);">
        <div class="d-flex align-items-center justify-content-between">
            <h2 style="font-size:14px;font-weight:600;margin:0;">Control de inventario</h2>
            <div class="d-flex gap-2 flex-wrap justify-content-end">
                <a href="{{ route('inventario.export.excel') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;" title="Exportar Excel">
                    <i class="bi bi-file-earmark-excel me-1"></i><span class="d-none d-sm-inline">Excel</span>
                </a>
                <a href="{{ route('inventario.export.pdf') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;" title="Exportar PDF">
                    <i class="bi bi-file-earmark-pdf me-1"></i><span class="d-none d-sm-inline">PDF</span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Producto</th>
                    <th class="d-none d-md-table-cell" style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Categoría</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Stock</th>
                    <th class="d-none d-sm-table-cell" style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Mínimo</th>
                    <th class="d-none d-sm-table-cell" style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Nivel</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Estado</th>
                    @if(auth()->user()->rol === 'admin')
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Ajustar</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                @php
                    $bajo = $producto->stock <= $producto->umbral_min;
                    $pct = min(100, $producto->umbral_min > 0 ? round(($producto->stock / ($producto->umbral_min * 3)) * 100) : 100);
                    $color = $producto->stock == 0 ? '#dc2626' : ($bajo ? '#f59e0b' : '#16a34a');
                @endphp
                <tr>
                    <td style="font-weight:500;">
                        {{ $producto->nombre }}
                        <div class="d-md-none" style="font-size:11px;color:#9e9d99;margin-top:2px;">{{ $producto->categoria }}</div>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <span class="badge" style="background:#f1f0ec;color:#6b6a66;">{{ $producto->categoria }}</span>
                    </td>
                    <td><span style="font-weight:600;color:{{ $bajo ? '#991b1b' : '#166534' }};">{{ $producto->stock }} uds</span></td>
                    <td class="d-none d-sm-table-cell" style="color:#9e9d99;">{{ $producto->umbral_min }} uds</td>
                    <td class="d-none d-sm-table-cell" style="min-width:80px;">
                        <div style="height:6px;border-radius:3px;background:rgba(0,0,0,0.08);overflow:hidden;">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:3px;"></div>
                        </div>
                    </td>
                    <td>
                        @if($producto->stock == 0)
                            <span class="badge bg-danger">Sin stock</span>
                        @elseif($bajo)
                            <span class="badge bg-warning text-dark">Bajo</span>
                        @else
                            <span class="badge bg-success">OK</span>
                        @endif
                    </td>
                    @if(auth()->user()->rol === 'admin')
                    <td>
                        <a href="{{ route('inventario.edit', $producto->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;font-size:12px;">
                            Ajustar
                        </a>
                    </td>
                    @endif
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5">Sin productos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection