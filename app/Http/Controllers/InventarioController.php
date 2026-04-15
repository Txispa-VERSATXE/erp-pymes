<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->get();
        $alertas   = Producto::whereRaw(['$expr' => ['$lte' => ['$stock', '$umbral_min']]])->get();
        return view('inventario.index', compact('productos', 'alertas'));
    }

    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('inventario.edit', compact('producto'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tipo'     => 'required|in:incrementar,decrementar',
            'cantidad' => 'required|integer|min:1',
            'motivo'   => 'nullable|string|max:255',
        ]);

        $producto = Producto::findOrFail($id);

        if ($request->tipo === 'incrementar') {
            $producto->increment('stock', $request->cantidad);
        } else {
            $nuevoStock = max(0, $producto->stock - $request->cantidad);
            $producto->update(['stock' => $nuevoStock]);
        }

        return redirect()->route('inventario.index')
            ->with('success', 'Stock actualizado correctamente.');
    }

    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('inventario.show', compact('producto'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function destroy(string $id) {}
}