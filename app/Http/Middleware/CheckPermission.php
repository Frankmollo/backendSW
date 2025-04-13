<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = $request->user();

        if(!$user){
            return response()->json(['error'=> 'INICIA SESION PRRA'], 401);
            if(!$user->tienePermiso($permission)){
                return response()->json(['error' => 'No autorizado'], 403);
            }
        }
        /*
        if (!$user || !$user->tienePermiso($permission)) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
            */

        return $next($request);
    }
}
