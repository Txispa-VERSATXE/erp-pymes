@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-size:14px;font-weight:600;margin:0;">Ventas ({{ $ventas->count() }})</h2>
        <a href="{{ route('ventas.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
            <i class="bi bi-plus-lg me-1"></i>Nueva venta
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">#</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Cliente</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Fecha</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Total</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Estado</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                @php $cliente = \App\Models\Cliente::find($venta->cliente_id); @endphp
                <tr>
<td style="font-family:monospace;color:#9e9d99;">#{{ strtoupper(substr($venta->id, -6)) }}</td>                    <td style="font-weight:500;">{{ $cliente->nombre ?? '—' }}</td>
                    <td>{{ $venta->fecha_venta }}</td>
                    <td style="font-family:monospace;font-weight:600;">{{ number_format($venta->total, 2, ',', '.') }} €</td>
                    <td>
                        @if(auth()->user()->rol === 'admin')
                        <form method="POST" action="{{ route('ventas.update', $venta->id) }}">
                            @csrf @method('PUT')
                            <select name="estado" class="form-select form-select-sm" style="width:auto;font-size:12px;" onchange="this.form.submit()">
                                <option value="pendiente" {{ $venta->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ $venta->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="cancelado" {{ $venta->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </form>
                        @else
                        <span class="badge rounded-pill
                            @if($venta->estado === 'pagado') bg-success
                            @elseif($venta->estado === 'cancelado') bg-danger
                            @else bg-warning text-dark
                            @endif">
                            {{ $venta->estado }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->rol === 'admin')
                            <form method="POST" action="{{ route('ventas.destroy', $venta->id) }}" onsubmit="return confirm('¿Eliminar venta?')">
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
                <tr><td colspan="6" class="text-center text-muted py-5">Sin ventas registradas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection