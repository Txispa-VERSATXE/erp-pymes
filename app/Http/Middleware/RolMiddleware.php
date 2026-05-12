<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRol = auth()->user()->rol;

        // MasterUser tiene acceso a todo
        if ($userRol === 'masteradmin') {
            return $next($request);
        }

        if ($userRol !== $rol) {
            abort(403, 'Acceso no autorizado. Se requiere rol: ' . $rol);
        }

        return $next($request);
    }
}