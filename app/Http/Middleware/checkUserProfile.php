<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class checkUserProfile
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
        if ($request->has('api_token'))
        {
            $token = $request->input('api_token');
            $usuario = User::where('api_token', $token)->first();

            if(!$usuario)
            {
                return response("Api key no vale", 401);
            }
            else
            {
                $request->usuario = $usuario;
                return $next($request);
            }
        }
        else
        {
            return response("No api key", 401);
        }
    }
}
