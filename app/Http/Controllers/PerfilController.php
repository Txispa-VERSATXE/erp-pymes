<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        return view('perfil.index', compact('usuario'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email',
        ]);

        $usuario = auth()->user();
        $usuario->update([
            'nombre' => $request->nombre,
            'email'  => $request->email,
        ]);

        return redirect()->route('perfil.index')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'password_actual'  => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        $usuario = auth()->user();

        if (!Hash::check($request->password_actual, $usuario->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        $usuario->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('perfil.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}