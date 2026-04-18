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
        .badge-pagado   { background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 4px; }
        .badge-pendiente { background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 4px; }
        .badge-cancelado { background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px; }
        .total-row td { font-weight: bold; background: #f9f8f5; }
        .footer { margin-top: 20px; font-size: 10px; color: #9e9d99; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ERP PYMES — Listado de Ventas</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            @php $cliente = \App\Models\Cliente::find($venta->cliente_id); @endphp
            <tr>
                <td>#{{ strtoupper(substr($venta->id, -6)) }}</td>
                <td>{{ $cliente->nombre ?? '—' }}</td>
                <td>{{ $venta->fecha_venta }}</td>
                <td>{{ number_format($venta->total, 2, ',', '.') }} €</td>
                <td>
                    <span class="badge-{{ $venta->estado }}">{{ ucfirst($venta->estado) }}</span>
                </td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>{{ number_format($ventas->sum('total'), 2, ',', '.') }} €</td>
                <td>{{ $ventas->count() }} ventas</td>
            </tr>
        </tbody>
    </table>
    <div class="footer">Generado por ERP PYMES</div>
</body>
</html>