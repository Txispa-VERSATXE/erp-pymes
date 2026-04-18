@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;gap:12px;">
        <h2 style="font-size:14px;font-weight:600;margin:0;">Productos (<span id="contador">{{ $productos->count() }}</span>)</h2>
        <div class="d-flex gap-2 align-items-center">
            <div style="display:flex;align-items:center;gap:8px;padding:0 12px;background:#f9f8f5;border:1px solid rgba(0,0,0,0.1);border-radius:8px;height:36px;min-width:240px;">
                <i class="bi bi-search" style="color:#9e9d99;font-size:13px;"></i>
                <input id="buscador" type="text" placeholder="Buscar producto…" style="background:none;border:none;outline:none;font-size:13px;color:#1a1916;width:100%;">
            </div>
            <select id="filtroCat" style="height:36px;padding:0 10px;border:1px solid rgba(0,0,0,0.1);border-radius:8px;font-size:13px;color:#1a1916;background:#f9f8f5;cursor:pointer;">
                <option value="">Todas las categorías</option>
                @foreach($productos->pluck('categoria')->unique()->sort() as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('productos.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
                <i class="bi bi-plus-lg me-1"></i>Nuevo producto
            </a>
            @endif
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Nombre</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Categoría</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Precio</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Stock</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Estado</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                @php $bajo = $producto->stock <= $producto->umbral_min; @endphp
                <tr class="fila-producto" data-categoria="{{ $producto->categoria }}">
                    <td style="font-weight:500;">{{ $producto->nombre }}</td>
                    <td><span class="badge" style="background:#f1f0ec;color:#6b6a66;">{{ $producto->categoria }}</span></td>
                    <td style="font-family:monospace;">{{ number_format($producto->precio, 2, ',', '.') }} €</td>
                    <td><span style="font-weight:600;color:{{ $bajo ? '#991b1b' : '#166534' }};">{{ $producto->stock }} uds</span></td>
                    <td>
                        @if($producto->stock == 0)
                            <span class="badge bg-danger">Sin stock</span>
                        @elseif($bajo)
                            <span class="badge bg-warning text-dark">Stock bajo</span>
                        @else
                            <span class="badge bg-success">Disponible</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if(auth()->user()->rol === 'admin')
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" onsubmit="return confirm('¿Eliminar producto?')">
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
                <tr><td colspan="6" class="text-center text-muted py-5">Sin productos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($productos->hasPages())
    <div style="padding:16px 20px;border-top:1px solid rgba(0,0,0,0.08);">
        {{ $productos->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
const buscador = document.getElementById('buscador');
const filtroCat = document.getElementById('filtroCat');
const filas = document.querySelectorAll('.fila-producto');
const contador = document.getElementById('contador');

const normalizar = t => t.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();

function filtrar() {
    const termino = normalizar(buscador.value);
    const categoria = normalizar(filtroCat.value);
    let visibles = 0;

    filas.forEach(fila => {
        const texto = normalizar(fila.textContent);
        const cat = normalizar(fila.dataset.categoria);
        const coincideTexto = texto.includes(termino);
        const coincideCat = categoria === '' || cat === categoria;
        const mostrar = coincideTexto && coincideCat;
        fila.style.display = mostrar ? '' : 'none';
        if (mostrar) visibles++;
    });

    contador.textContent = visibles;
}

buscador.addEventListener('input', filtrar);
filtroCat.addEventListener('change', filtrar);
</script>
@endsection