@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;gap:12px;">
        <h2 style="font-size:14px;font-weight:600;margin:0;">Ventas (<span id="contador">{{ $ventas->count() }}</span>)</h2>
        <div class="d-flex gap-2 align-items-center">
            <div style="display:flex;align-items:center;gap:8px;padding:0 12px;background:#f9f8f5;border:1px solid rgba(0,0,0,0.1);border-radius:8px;height:36px;min-width:220px;">
                <i class="bi bi-search" style="color:#9e9d99;font-size:13px;"></i>
                <input id="buscador" type="text" placeholder="Buscar venta…" style="background:none;border:none;outline:none;font-size:13px;color:#1a1916;width:100%;">
            </div>
            <select id="filtroEstado" style="height:36px;padding:0 10px;border:1px solid rgba(0,0,0,0.1);border-radius:8px;font-size:13px;color:#1a1916;background:#f9f8f5;cursor:pointer;">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="pagado">Pagado</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <a href="{{ route('ventas.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
                <i class="bi bi-plus-lg me-1"></i>Nueva venta
            </a>
        </div>
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
                <tr class="fila-venta" data-estado="{{ $venta->estado }}">
                    <td style="font-family:monospace;color:#9e9d99;">#{{ strtoupper(substr($venta->id, -6)) }}</td>
                    <td style="font-weight:500;">{{ $cliente->nombre ?? '—' }}</td>
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

@section('scripts')
<script>
const buscador = document.getElementById('buscador');
const filtroEstado = document.getElementById('filtroEstado');
const filas = document.querySelectorAll('.fila-venta');
const contador = document.getElementById('contador');

const normalizar = t => t.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();

function filtrar() {
    const termino = normalizar(buscador.value);
    const estado = filtroEstado.value.toLowerCase();
    let visibles = 0;

    filas.forEach(fila => {
        const texto = normalizar(fila.textContent);
        const estadoFila = fila.dataset.estado.toLowerCase();
        const coincideTexto = texto.includes(termino);
        const coincideEstado = estado === '' || estadoFila === estado;
        const mostrar = coincideTexto && coincideEstado;
        fila.style.display = mostrar ? '' : 'none';
        if (mostrar) visibles++;
    });

    contador.textContent = visibles;
}

buscador.addEventListener('input', filtrar);
filtroEstado.addEventListener('change', filtrar);
</script>
@endsection