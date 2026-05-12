@extends('layouts.app')

@section('title', 'Compras')

@section('content')
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);">
        <div class="d-flex align-items-center justify-content-between">
            <h2 style="font-size:14px;font-weight:600;margin:0;">Compras ({{ $compras->count() }})</h2>
            <div class="d-flex gap-2 flex-wrap justify-content-end">
                <a href="{{ route('compras.export.excel') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;" title="Exportar Excel">
                    <i class="bi bi-file-earmark-excel me-1"></i><span class="d-none d-sm-inline">Excel</span>
                </a>
                <a href="{{ route('compras.export.pdf') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;" title="Exportar PDF">
                    <i class="bi bi-file-earmark-pdf me-1"></i><span class="d-none d-sm-inline">PDF</span>
                </a>
                @if(auth()->user()->rol === 'admin')
                <a href="{{ route('compras.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
                    <i class="bi bi-plus-lg me-1"></i><span class="d-none d-sm-inline">Nueva compra</span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th class="d-none d-sm-table-cell" style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">#</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Proveedor</th>
                    <th class="d-none d-md-table-cell" style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Fecha</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Total</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Estado</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                @php $proveedor = \App\Models\Proveedor::find($compra->proveedor_id); @endphp
                <tr>
                    <td class="d-none d-sm-table-cell" style="font-family:monospace;color:#9e9d99;">#{{ strtoupper(substr($compra->id, -6)) }}</td>
                    <td style="font-weight:500;">
                        {{ $proveedor->nombre ?? '—' }}
                        <div class="d-md-none" style="font-size:11px;color:#9e9d99;margin-top:2px;">{{ $compra->fecha_compra }}</div>
                    </td>
                    <td class="d-none d-md-table-cell">{{ $compra->fecha_compra }}</td>
                    <td style="font-family:monospace;font-weight:600;">{{ number_format($compra->total, 2, ',', '.') }} €</td>
                    <td>
                        <span class="badge rounded-pill @if($compra->estado === 'recibido') bg-success @elseif($compra->estado === 'cancelado') bg-danger @else bg-warning text-dark @endif">
                            {{ $compra->estado }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->rol === 'admin')
                            <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('compras.destroy', $compra->id) }}" onsubmit="return confirm('¿Eliminar compra?')">
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
                <tr><td colspan="6" class="text-center text-muted py-5">Sin compras registradas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($compras->hasPages())
    <div style="padding:16px 20px;border-top:1px solid rgba(0,0,0,0.08);">
        {{ $compras->links() }}
    </div>
    @endif
</div>
@endsection