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

        if (auth()->user()->rol !== $rol) {
            abort(403, 'Acceso no autorizado. Se requiere rol: ' . $rol);
        }

        return $next($request);
    }
}