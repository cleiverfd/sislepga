<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CheckPermiso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Excepciones: rutas que no requieren validación de permisos
        $excepciones = [
            'login',
            'logout',
            'register',
            'password',
        ];

        $slug = $request->segment(1);

        if ($request->is('css/*') || $request->is('js/*') || $request->is('images/*') || $request->is('vendor/*')) {
            return $next($request);
        }

        // Si la ruta está en excepciones, se deja pasar
        if (in_array($slug, $excepciones)) {
            return $next($request);
        }

        // Si es una petición AJAX o JSON, no validamos
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        $user = Auth::user();

        // Si no hay usuario autenticado
        if (!$user) {
            return redirect()->route('login');
        }

        // Tomamos el primer segmento de la URL como slug
        $slug = $request->segment(1);

        // Aseguramos que los permisos estén cargados
        $permisos = $user->permisos()->pluck('slug')->toArray();

        if (!in_array($slug, $permisos)) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
