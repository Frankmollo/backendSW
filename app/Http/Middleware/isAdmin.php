<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $usuario = auth('api')->user();
       $rolAdmin = Rol::where('nombre', '=', 'Admin');
       $usuarioRol = Rol::find($usuario->rol_id)->nombre;
        if($usuario && Rol::find($usuario->rol_id)->nombre === 'Admin'){
            return $next($request);
        }else{
            return response()->json(['message' => 'NO MOLLADMIN PRRA'], 403);
        }
    }
}
