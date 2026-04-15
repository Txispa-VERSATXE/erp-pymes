@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- KPIs --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div style="width:36px;height:36px;background:#e8f0f9;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                <i class="bi bi-cart3" style="color:#1a3a5c;"></i>
            </div>
            <div style="font-size:11px;font-weight:600;color:#9e9d99;text-transform:uppercase;letter-spacing:0.4px;">Ventas totales</div>
            <div style="font-size:26px;font-weight:700;letter-spacing:-0.5px;">{{ number_format($importeTotal, 2, ',', '.') }} €</div>
            <div style="font-size:12px;color:#6b6a66;">{{ $totalVentas }} operaciones</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div style="width:36px;height:36px;background:#dcfce7;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                <i class="bi bi-people" style="color:#166534;"></i>
            </div>
            <div style="font-size:11px;font-weight:600;color:#9e9d99;text-transform:uppercase;letter-spacing:0.4px;">Clientes</div>
            <div style="font-size:26px;font-weight:700;letter-spacing:-0.5px;">{{ $totalClientes }}</div>
            <div style="font-size:12px;color:#6b6a66;">Registrados</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div style="width:36px;height:36px;background:#fef3c7;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                <i class="bi bi-box-seam" style="color:#92400e;"></i>
            </div>
            <div style="font-size:11px;font-weight:600;color:#9e9d99;text-transform:uppercase;letter-spacing:0.4px;">Productos</div>
            <div style="font-size:26px;font-weight:700;letter-spacing:-0.5px;">{{ $totalProductos }}</div>
            <div style="font-size:12px;color:#6b6a66;">{{ $alertasStock->count() }} con stock bajo</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div style="width:36px;height:36px;background:#dbeafe;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                <i class="bi bi-graph-up" style="color:#1e40af;"></i>
            </div>
            <div style="font-size:11px;font-weight:600;color:#9e9d99;text-transform:uppercase;letter-spacing:0.4px;">Ventas del mes</div>
            <div style="font-size:26px;font-weight:700;letter-spacing:-0.5px;">{{ number_format($ventasMes, 2, ',', '.') }} €</div>
            <div style="font-size:12px;color:#6b6a66;">{{ $ventasPendientes }} pendientes</div>
        </div>
    </div>
</div>

{{-- Alertas de stock --}}
@if($alertasStock->count() > 0)
<div class="alert-stock mb-4">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>{{ $alertasStock->count() }} productos</strong> con stock por debajo del mínimo:
    {{ $alertasStock->pluck('nombre')->join(', ') }}
</div>
@endif

<div class="row g-3">
    {{-- Gráfico ventas por mes --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-600 mb-3" style="font-size:14px;font-weight:600;">Ventas por mes</h6>
                <div style="display:flex;align-items:flex-end;gap:8px;height:120px;">
                    @foreach($ventasPorMes as $v)
                    @php $maxTotal = collect($ventasPorMes)->max('total') ?: 1; @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <span style="font-size:10px;color:#9e9d99;">{{ number_format($v['total'], 0, ',', '.') }}</span>
                        <div style="width:100%;height:{{ max(4, ($v['total']/$maxTotal)*80) }}px;background:#1a3a5c;border-radius:3px 3px 0 0;"></div>
                        <span style="font-size:10px;color:#6b6a66;">{{ $v['mes'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Últimas ventas --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-body p-0">
                <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);">
                    <h6 style="font-size:14px;font-weight:600;margin:0;">Últimas ventas</h6>
                </div>
                <table class="table table-hover mb-0" style="font-size:13px;">
                    <tbody>
                        @forelse($ultimasVentas as $venta)
                        <tr>
                            <td>
                                <div style="font-weight:500;">#{{ str_pad($venta->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div style="font-size:11px;color:#9e9d99;">{{ $venta->fecha_venta }}</div>
                            </td>
                            <td style="text-align:right;font-weight:600;">{{ number_format($venta->total, 2, ',', '.') }} €</td>
                            <td>
                                <span class="badge rounded-pill
                                    @if($venta->estado === 'pagado') bg-success
                                    @elseif($venta->estado === 'cancelado') bg-danger
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ $venta->estado }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">Sin ventas registradas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection