<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Compra;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index()
    {
        // Totales generales
        $totalClientes  = Cliente::count();
        $totalProductos = Producto::count();
        $totalVentas    = Venta::count();
        $totalCompras   = Compra::count();

        // Ventas del mes actual
        $mesActual = now()->format('Y-m');
        $ventasMes = Venta::whereRaw([
            'fecha_venta' => ['$regex' => "^$mesActual"]
        ])->sum('total');

        // Ventas pendientes
        $ventasPendientes = Venta::where('estado', 'pendiente')->count();

        // Importe total de todas las ventas
        $importeTotal = Venta::sum('total');

        // Productos con stock bajo
        $alertasStock = Producto::whereRaw([
            '$expr' => ['$lte' => ['$stock', '$umbral_min']]
        ])->get();

        // Últimas 5 ventas
        $ultimasVentas = Venta::orderBy('created_at', 'desc')->limit(5)->get();

        // Ventas por mes (últimos 6 meses)
        $ventasPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes   = $fecha->format('Y-m');
            $ventasPorMes[] = [
                'mes'   => $fecha->format('M Y'),
                'total' => Venta::whereRaw([
                    'fecha_venta' => ['$regex' => "^$mes"]
                ])->sum('total'),
            ];
        }

        return view('dashboard', compact(
            'totalClientes',
            'totalProductos',
            'totalVentas',
            'totalCompras',
            'ventasMes',
            'ventasPendientes',
            'importeTotal',
            'alertasStock',
            'ultimasVentas',
            'ventasPorMes'
        ));
    }
}