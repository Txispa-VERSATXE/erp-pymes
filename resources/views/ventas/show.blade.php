@extends('layouts.app')

@section('title', 'Detalle venta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">
                    Venta #{{ strtoupper(substr($venta->id, -6)) }}
                </h2>
                <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Cliente</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $cliente->nombre ?? '—' }}</div>
                        </div>
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Fecha</div>
                            <div style="font-size:13.5px;font-weight:500;">{{ $venta->fecha_venta }}</div>
                        </div>
                        <div style="padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.08);">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Estado</div>
                            <span class="badge rounded-pill
                                @if($venta->estado === 'pagado') bg-success
                                @elseif($venta->estado === 'cancelado') bg-danger
                                @else bg-warning text-dark
                                @endif">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </div>
                        <div style="padding:10px 0;">
                            <div style="font-size:12px;color:#9e9d99;font-weight:500;">Total</div>
                            <div style="font-size:22px;font-weight:700;">{{ number_format($venta->total, 2, ',', '.') }} €</div>
                        </div>
                    </div>
                </div>

                <h6 style="font-size:13px;font-weight:600;margin-bottom:12px;">Líneas de venta</h6>
                <div class="table-responsive">
                    <table class="table" style="font-size:13px;">
                        <thead style="background:#f9f8f5;">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($detalles as $detalle)
                            @php $producto = \App\Models\Producto::find($detalle->producto_id); @endphp
                            <tr>
                                <td style="font-weight:500;">{{ $producto->nombre ?? '—' }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>{{ number_format($detalle->precio_unit, 2, ',', '.') }} €</td>
                                <td style="font-weight:600;">{{ number_format($detalle->cantidad * $detalle->precio_unit, 2, ',', '.') }} €</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Sin detalles</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;font-weight:600;">Total:</td>
                                <td style="font-weight:700;font-size:15px;">{{ number_format($venta->total, 2, ',', '.') }} €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection