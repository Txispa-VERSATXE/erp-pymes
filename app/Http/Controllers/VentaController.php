<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::orderBy('created_at', 'desc')->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes  = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('stock', '>', 0)->orderBy('nombre')->get();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'             => 'required',
            'estado'                 => 'required|in:pendiente,pagado,cancelado',
            'detalles'               => 'required|array|min:1',
            'detalles.*.producto_id' => 'required',
            'detalles.*.cantidad'    => 'required|integer|min:1',
        ]);

        $total    = 0;
        $detalles = [];

        foreach ($request->detalles as $detalle) {
            $producto  = Producto::findOrFail($detalle['producto_id']);
            $subtotal  = $producto->precio * $detalle['cantidad'];
            $total    += $subtotal;

            $detalles[] = [
                'producto_id' => $producto->id,
                'cantidad'    => $detalle['cantidad'],
                'precio_unit' => $producto->precio,
                'subtotal'    => $subtotal,
            ];

            $producto->decrement('stock', $detalle['cantidad']);
        }

        $venta = Venta::create([
            'cliente_id'  => $request->cliente_id,
            'usuario_id'  => auth()->id(),
            'fecha_venta' => now()->toDateString(),
            'total'       => $total,
            'estado'      => $request->estado,
        ]);

        foreach ($detalles as $detalle) {
            DetalleVenta::create(array_merge($detalle, ['venta_id' => $venta->id]));
        }

        return redirect()->route('ventas.index')
            ->with('success', 'Venta registrada correctamente.');
    }

    public function show(string $id)
    {
        $venta    = Venta::findOrFail($id);
        $cliente  = Cliente::find($venta->cliente_id);
        $detalles = DetalleVenta::where('venta_id', $id)->get();
        return view('ventas.show', compact('venta', 'cliente', 'detalles'));
    }

    public function edit(string $id)
    {
        $venta = Venta::findOrFail($id);
        return view('ventas.edit', compact('venta'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,pagado,cancelado',
        ]);

        $venta = Venta::findOrFail($id);
        $venta->update(['estado' => $request->estado]);
        return redirect()->route('ventas.index')
            ->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        Venta::findOrFail($id)->delete();
        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada correctamente.');
    }
}