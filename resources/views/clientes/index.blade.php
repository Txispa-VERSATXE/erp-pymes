@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;gap:12px;">
        <h2 style="font-size:14px;font-weight:600;margin:0;">Clientes (<span id="contador">{{ $clientes->count() }}</span>)</h2>
        <div class="d-flex gap-2 align-items-center">
            <div style="display:flex;align-items:center;gap:8px;padding:0 12px;background:#f9f8f5;border:1px solid rgba(0,0,0,0.1);border-radius:8px;height:36px;min-width:240px;">
                <i class="bi bi-search" style="color:#9e9d99;font-size:13px;"></i>
                <input id="buscador" type="text" placeholder="Buscar cliente…" style="background:none;border:none;outline:none;font-size:13px;color:#1a1916;width:100%;">
            </div>
            @if(auth()->user()->rol === 'admin')
            <a href="{{ route('clientes.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
                <i class="bi bi-plus-lg me-1"></i>Nuevo cliente
            </a>
            @endif
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;" id="tablaClientes">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Nombre</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Email</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Teléfono</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Alta</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Acciones</th>
                </tr>
            </thead>
            <tbody id="cuerpoTabla">
                @forelse($clientes as $cliente)
                <tr class="fila-cliente">
                    <td style="font-weight:500;">{{ $cliente->nombre }}</td>
                    <td style="color:#6b6a66;">{{ $cliente->email }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td style="color:#9e9d99;font-size:12px;">{{ $cliente->created_at?->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->rol === 'admin')
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('clientes.destroy', $cliente->id) }}" onsubmit="return confirm('¿Eliminar cliente?')">
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
                <tr><td colspan="5" class="text-center text-muted py-5">Sin clientes registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($clientes->hasPages())
    <div style="padding:16px 20px;border-top:1px solid rgba(0,0,0,0.08);">
        {{ $clientes->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
const buscador = document.getElementById('buscador');
const filas = document.querySelectorAll('.fila-cliente');
const contador = document.getElementById('contador');

const normalizar = t => t.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();

buscador.addEventListener('input', function() {
    const termino = normalizar(this.value);
    let visibles = 0;

    filas.forEach(fila => {
        const texto = normalizar(fila.textContent);
        const coincide = texto.includes(termino);
        fila.style.display = coincide ? '' : 'none';
        if (coincide) visibles++;
    });

    contador.textContent = visibles;
});
</script>
@endsection