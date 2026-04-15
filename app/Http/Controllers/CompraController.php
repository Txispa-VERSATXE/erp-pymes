<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleCompra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::orderBy('created_at', 'desc')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos   = Producto::orderBy('nombre')->get();
        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id'            => 'required',
            'estado'                  => 'required|in:pendiente,recibido,cancelado',
            'detalles'                => 'required|array|min:1',
            'detalles.*.producto_id'  => 'required',
            'detalles.*.cantidad'     => 'required|integer|min:1',
            'detalles.*.costo_unit'   => 'required|numeric|min:0',
        ]);

        $total    = 0;
        $detalles = [];

        foreach ($request->detalles as $detalle) {
            $producto = Producto::findOrFail($detalle['producto_id']);
            $subtotal = $detalle['costo_unit'] * $detalle['cantidad'];
            $total   += $subtotal;

            $detalles[] = [
                'producto_id' => $producto->id,
                'cantidad'    => $detalle['cantidad'],
                'costo_unit'  => $detalle['costo_unit'],
                'subtotal'    => $subtotal,
            ];

            // Si la compra es recibida actualizamos stock
            if ($request->estado === 'recibido') {
                $producto->increment('stock', $detalle['cantidad']);
            }
        }

        $compra = Compra::create([
            'proveedor_id'  => $request->proveedor_id,
            'usuario_id'    => auth()->id(),
            'fecha_compra'  => now()->toDateString(),
            'total'         => $total,
            'estado'        => $request->estado,
        ]);

        foreach ($detalles as $detalle) {
            DetalleCompra::create(array_merge($detalle, ['compra_id' => $compra->id]));
        }

        return redirect()->route('compras.index')
            ->with('success', 'Compra registrada correctamente.');
    }

    public function show(string $id)
    {
        $compra    = Compra::findOrFail($id);
        $proveedor = Proveedor::find($compra->proveedor_id);
        $detalles  = DetalleCompra::where('compra_id', $id)->get();
        return view('compras.show', compact('compra', 'proveedor', 'detalles'));
    }

    public function edit(string $id)
    {
        $compra = Compra::findOrFail($id);
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,recibido,cancelado',
        ]);

        $compra = Compra::findOrFail($id);
        $compra->update(['estado' => $request->estado]);
        return redirect()->route('compras.index')
            ->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        Compra::findOrFail($id)->delete();
        return redirect()->route('compras.index')
            ->with('success', 'Compra eliminada correctamente.');
    }
}