<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('created_at', 'desc')->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email',
            'telefono' => 'nullable|string|max:20',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function show(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $compras   = \App\Models\Compra::where('proveedor_id', $id)->get();
        return view('proveedores.show', compact('proveedor', 'compras'));
    }

    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email',
            'telefono' => 'nullable|string|max:20',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Proveedor::findOrFail($id)->delete();
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}