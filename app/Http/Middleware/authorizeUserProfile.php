<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class authorizeUserProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $usuario = $request->usuario;
        if ($usuario->tipo_empleado == 'RRHH' || $usuario->tipo_empleado == 'directivo')
        {
            return $next($request);

        }
        else
        {
            return response('Usuario no autorizado', 401);
        }
    }
}
