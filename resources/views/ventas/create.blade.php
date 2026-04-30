@extends('layouts.app')

@section('title', 'Nueva venta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div style="padding:16px 20px;border-bottom:1px solid rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:space-between;">
                <h2 style="font-size:14px;font-weight:600;margin:0;">Nueva venta</h2>
                <a href="{{ route('ventas.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
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
                <form method="POST" action="{{ route('ventas.store') }}" id="ventaForm">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Cliente *</label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="">Seleccionar cliente...</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="pendiente">Pendiente</option>
                                <option value="pagado">Pagado</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h6 style="font-size:13px;font-weight:600;margin-bottom:12px;">Líneas de venta</h6>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <select id="productoSelect" class="form-select" style="font-size:13px;">
                                <option value="">Seleccionar producto...</option>
                                @foreach($productos as $producto)
                                <option value="{{ $producto->id }}"
                                    data-precio="{{ $producto->precio }}"
                                    data-nombre="{{ $producto->nombre }}"
                                    data-stock="{{ $producto->stock }}">
                                    {{ $producto->nombre }} — {{ number_format($producto->precio, 2, ',', '.') }} € (stock: {{ $producto->stock }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="cantidadInput" class="form-control" placeholder="Cant." min="1" value="1" style="font-size:13px;">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn w-100" style="background:#1a3a5c;color:#fff;font-size:13px;" onclick="añadirLinea()">
                                <i class="bi bi-plus-lg me-1"></i>Añadir
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive mb-3">
                        <table class="table" style="font-size:13px;" id="lineasTable">
                            <thead style="background:#f9f8f5;">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio unit.</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="lineasBody">
                                <tr id="emptyRow">
                                    <td colspan="5" class="text-center text-muted py-3">Sin productos añadidos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="text-align:right;font-size:16px;font-weight:700;margin-bottom:16px;">
                        Total: <span id="totalLabel">0,00 €</span>
                    </div>

                    <div id="lineasContainer"></div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn" style="background:#1a3a5c;color:#fff;">
                            <i class="bi bi-floppy me-1"></i>Confirmar venta
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
    const select = document.getElementById('productoSelect');
    const cantidad = parseInt(document.getElementById('cantidadInput').value);
    const option = select.options[select.selectedIndex];

    if (!select.value || cantidad < 1) return;

    const productoId = select.value;
    const nombre = option.dataset.nombre;
    const precio = parseFloat(option.dataset.precio);
    const stock = parseInt(option.dataset.stock);

    const existing = lineas.findIndex(l => l.producto_id === productoId);
    const cantidadActual = existing >= 0 ? lineas[existing].cantidad : 0;
    const cantidadTotal = cantidadActual + cantidad;

    if (cantidadTotal > stock) {
        alert(`Stock insuficiente. Stock disponible: ${stock}. Ya tienes ${cantidadActual} unidades en el pedido.`);
        return;
    }

    if (existing >= 0) {
        lineas[existing].cantidad = cantidadTotal;
    } else {
        lineas.push({ producto_id: productoId, nombre, precio, cantidad });
    }

    renderLineas();
    select.value = '';
    document.getElementById('cantidadInput').value = 1;
}

function eliminarLinea(index) {
    lineas.splice(index, 1);
    renderLineas();
}

function renderLineas() {
    const tbody = document.getElementById('lineasBody');
    const container = document.getElementById('lineasContainer');

    tbody.innerHTML = '';
    container.innerHTML = '';

    if (lineas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-3">Sin productos añadidos</td></tr>';
        document.getElementById('totalLabel').textContent = '0,00 €';
        return;
    }

    let total = 0;
    lineas.forEach((l, i) => {
        const subtotal = l.precio * l.cantidad;
        total += subtotal;

        tbody.innerHTML += `
            <tr>
                <td style="font-weight:500;">${l.nombre}</td>
                <td>${l.cantidad}</td>
                <td>${l.precio.toFixed(2).replace('.', ',')} €</td>
                <td style="font-weight:600;">${subtotal.toFixed(2).replace('.', ',')} €</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger" style="padding:2px 8px;" onclick="eliminarLinea(${i})"><i class="bi bi-trash"></i></button></td>
            </tr>`;

        container.innerHTML += `
            <input type="hidden" name="detalles[${i}][producto_id]" value="${l.producto_id}">
            <input type="hidden" name="detalles[${i}][cantidad]" value="${l.cantidad}">`;
    });

    document.getElementById('totalLabel').textContent = total.toFixed(2).replace('.', ',') + ' €';
}
</script>
@endsection