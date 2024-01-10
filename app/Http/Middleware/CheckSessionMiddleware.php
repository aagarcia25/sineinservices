<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CheckSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $endpoint = $request->path();
        // Verificar la existencia de la cabecera

        if (Str::contains($endpoint, 'login') || Str::contains($endpoint, 'logout')) {
            return $next($request);
        } else {
            if (!$request->header('Session')) {
                return response()->json(['error' => 'No se proporcionó la cabecera de session.'], 401);
            }

            try {
                $usuario = Usuario::where('IdSession', $request->header('Session'))->first();

                if (!$usuario) {
                    return response()->json(['error' => 'Session no Valida'], 409);
                }

                return $next($request);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al procesar la solicitud.'], 500);
            }
        }
    }
}
