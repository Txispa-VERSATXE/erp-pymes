@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-size:14px;font-weight:600;margin:0;">Clientes ({{ $clientes->count() }})</h2>
        @if(auth()->user()->rol === 'admin')
        <a href="{{ route('clientes.create') }}" class="btn btn-sm" style="background:#1a3a5c;color:#fff;border-radius:8px;">
            <i class="bi bi-plus-lg me-1"></i>Nuevo cliente
        </a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13.5px;">
            <thead style="background:#f9f8f5;">
                <tr>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Nombre</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Email</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Teléfono</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Alta</th>
                    <th style="font-size:11px;color:#9e9d99;text-transform:uppercase;letter-spacing:0.5px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr>
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
</div>
@endsection