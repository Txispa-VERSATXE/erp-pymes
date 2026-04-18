<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    }

    public function exportPdf()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('exports.clientes-pdf', compact('clientes'));
        return $pdf->download('clientes.pdf');
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    public function edit(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Cliente::findOrFail($id)->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}