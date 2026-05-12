<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        // MasterUser no aparece en el listado
        $usuarios = Usuario::where('rol', '!=', 'masteradmin')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email|unique:mongodb.usuarios,email',
            'password' => 'required|string|min:6|confirmed',
            'rol'      => 'required|in:admin,empleado',
        ]);

        Usuario::create([
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Proteger al MasterUser
        if ($usuario->rol === 'masteradmin') {
            abort(404);
        }

        return view('usuarios.show', compact('usuario'));
    }

    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Proteger al MasterUser
        if ($usuario->rol === 'masteradmin') {
            abort(404);
        }

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Proteger al MasterUser
        if ($usuario->rol === 'masteradmin') {
            abort(404);
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email',
            'rol'    => 'required|in:admin,empleado',
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'email'  => $request->email,
            'rol'    => $request->rol,
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Proteger al MasterUser
        if ($usuario->rol === 'masteradmin') {
            abort(404);
        }

        // No se puede eliminar a uno mismo
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}