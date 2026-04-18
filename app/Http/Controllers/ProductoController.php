<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('created_at', 'desc')->paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportPdf()
    {
        $productos = Producto::orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('exports.productos-pdf', compact('productos'));
        return $pdf->download('productos.pdf');
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'categoria'  => 'required|string|max:50',
            'precio'     => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'umbral_min' => 'required|integer|min:0',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'categoria'  => 'required|string|max:50',
            'precio'     => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'umbral_min' => 'required|integer|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Producto::findOrFail($id)->delete();
        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}