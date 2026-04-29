@extends('layouts.app')

@section('title', 'Nueva compra')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">Nueva compra</h2>
                <a href="{{ route('compras.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger" style="font-size:13px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('compras.store') }}" id="formCompra">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Proveedor *</label>
                            <select name="proveedor_id" class="form-select" required>
                                <option value="">Seleccionar proveedor...</option>
                                @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="pendiente">Pendiente</option>
                                <option value="recibido">Recibido</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <div style="border-top:1px solid rgba(0,0,0,0.08);padding-top:20px;margin-bottom:16px;">
                        <h6 style="font-size:13px;font-weight:600;margin-bottom:12px;">Líneas de compra</h6>
                        <div class="d-flex gap-2 mb-3">
                            <select id="selectProducto" class="form-select">
                                <option value="">Seleccionar producto...</option>
                                @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                            <input type="number" id="inputCantidad" class="form-control" style="width:100px;" min="1" value="1" placeholder="Cant.">
                            <input type="number" id="inputCosto" class="form-control" style="width:120px;" min="0" step="0.01" value="0" placeholder="Coste €">
                            <button type="button" class="btn" style="background:#1a3a5c;color:#fff;white-space:nowrap;" onclick="añadirLinea()">
                                <i class="bi bi-plus-lg me-1"></i>Añadir
                            </button>
                        </div>
                        <table class="table" style="font-size:13px;">
                            <thead style="background:#f9f8f5;">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Coste unit.</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tablaLineas">
                                <tr id="filaVacia"><td colspan="5" class="text-center text-muted py-3">Sin productos añadidos</td></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right;font-weight:600;">Total:</td>
                                    <td style="font-weight:700;font-size:15px;" id="totalCompra">0,00 €</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                            <i class="bi bi-floppy me-1"></i>Confirmar compra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let lineas = [];

function añadirLinea() {
    const select = document.getElementById('selectProducto');
    const cantidad = parseInt(document.getElementById('inputCantidad').value);
    const costo = parseFloat(document.getElementById('inputCosto').value);

    if (!select.value || cantidad < 1 || costo < 0) {
        alert('Selecciona un producto, cantidad y coste válidos.');
        return;
    }

    const nombre = select.options[select.selectedIndex].dataset.nombre;
    lineas.push({ producto_id: select.value, nombre, cantidad, costo_unit: costo });

    renderLineas();
    select.value = '';
    document.getElementById('inputCantidad').value = 1;
    document.getElementById('inputCosto').value = 0;
}

function eliminarLinea(i) {
    lineas.splice(i, 1);
    renderLineas();
}

function renderLineas() {
    const tbody = document.getElementById('tablaLineas');
    const filaVacia = document.getElementById('filaVacia');
    let total = 0;
    let html = '';

    if (lineas.length === 0) {
        tbody.innerHTML = '<tr id="filaVacia"><td colspan="5" class="text-center text-muted py-3">Sin productos añadidos</td></tr>';
    } else {
        lineas.forEach((l, i) => {
            const subtotal = l.cantidad * l.costo_unit;
            total += subtotal;
            html += `<tr>
                <td>${l.nombre}
                    <input type="hidden" name="detalles[${i}][producto_id]" value="${l.producto_id}">
                    <input type="hidden" name="detalles[${i}][cantidad]" value="${l.cantidad}">
                    <input type="hidden" name="detalles[${i}][costo_unit]" value="${l.costo_unit}">
                </td>
                <td>${l.cantidad}</td>
                <td>${l.costo_unit.toFixed(2)} €</td>
                <td style="font-weight:600;">${subtotal.toFixed(2)} €</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger" style="padding:2px 7px;" onclick="eliminarLinea(${i})"><i class="bi bi-trash"></i></button></td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }

    document.getElementById('totalCompra').textContent = total.toFixed(2).replace('.', ',') + ' €';
}
</script>
@endsection