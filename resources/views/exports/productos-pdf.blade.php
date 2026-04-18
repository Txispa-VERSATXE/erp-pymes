<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1916; }
        .header { background: #1a3a5c; color: #fff; padding: 16px 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0 0; font-size: 11px; opacity: 0.7; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a3a5c; color: #fff; padding: 8px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 8px 12px; border-bottom: 1px solid #e5e4e0; font-size: 11px; }
        tr:nth-child(even) td { background: #f9f8f5; }
        .badge-ok   { background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 4px; }
        .badge-bajo { background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 4px; }
        .badge-sin  { background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px; }
        .footer { margin-top: 20px; font-size: 10px; color: #9e9d99; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ERP PYMES — Listado de Productos</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            @php $bajo = $producto->stock <= $producto->umbral_min; @endphp
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->categoria }}</td>
                <td>{{ number_format($producto->precio, 2, ',', '.') }} €</td>
                <td>{{ $producto->stock }} uds</td>
                <td>
                    @if($producto->stock == 0)
                        <span class="badge-sin">Sin stock</span>
                    @elseif($bajo)
                        <span class="badge-bajo">Stock bajo</span>
                    @else
                        <span class="badge-ok">Disponible</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Total: {{ $productos->count() }} productos</div>
</body>
</html>