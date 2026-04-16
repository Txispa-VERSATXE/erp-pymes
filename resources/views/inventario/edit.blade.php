@extends('layouts.app')

@section('title', 'Ajustar stock')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">Ajustar stock — {{ $producto->nombre }}</h2>
                <a href="{{ route('inventario.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div class="card-body p-4">
                <div style="background:#fef3c7;border:1px solid #fde68a;color:#92400e;border-radius:8px;padding:12px 16px;font-size:13px;margin-bottom:20px;">
                    Stock actual: <strong>{{ $producto->stock }} unidades</strong>
                </div>
                @if($errors->any())
                <div class="alert alert-danger" style="font-size:13px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('inventario.update', $producto->id) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Tipo de ajuste</label>
                            <select name="tipo" class="form-select" id="tipoSelect">
                                <option value="incrementar">Incrementar</option>
                                <option value="decrementar">Decrementar</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidadInput" class="form-control" min="1" value="{{ old('cantidad', 1) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Motivo</label>
                            <input type="text" name="motivo" class="form-control" placeholder="Ej: Devolución, corrección de inventario…" value="{{ old('motivo') }}">
                        </div>
                        <div class="col-12">
                            <div style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;border-radius:8px;padding:12px 16px;font-size:13px;" id="preview">
                                Stock resultante: <strong id="resultado">{{ $producto->stock + 1 }} unidades</strong>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                                <i class="bi bi-floppy me-1"></i>Aplicar ajuste
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const stockActual = {{ $producto->stock }};
const tipoSelect = document.getElementById('tipoSelect');
const cantidadInput = document.getElementById('cantidadInput');
const resultado = document.getElementById('resultado');

function actualizarPreview() {
    const cantidad = parseInt(cantidadInput.value) || 0;
    const tipo = tipoSelect.value;
    const nuevo = tipo === 'incrementar' ? stockActual + cantidad : Math.max(0, stockActual - cantidad);
    resultado.textContent = nuevo + ' unidades';
}

tipoSelect.addEventListener('change', actualizarPreview);
cantidadInput.addEventListener('input', actualizarPreview);
actualizarPreview();
</script>
@endsection