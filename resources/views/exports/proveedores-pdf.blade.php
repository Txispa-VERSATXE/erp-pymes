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
        .footer { margin-top: 20px; font-size: 10px; color: #9e9d99; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ERP PYMES — Listado de Proveedores</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Alta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->email }}</td>
                <td>{{ $proveedor->telefono ?? '—' }}</td>
                <td>{{ $proveedor->direccion ?? '—' }}</td>
                <td>{{ $proveedor->created_at?->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Total: {{ $proveedores->count() }} proveedores | Generado por ERP PYMES</div>
</body>
</html>