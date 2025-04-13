<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\rol_permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function verPermisosRol($id)
    {
        try {
            $rolEncontrado = Rol::find($id);
            if (!$rolEncontrado) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
            $permisosRol = rol_permiso::where('rol_id', $rolEncontrado->id)->get();
            return response()->json([$permisosRol], 200);
        } catch (\Exception $e) {
            return response()->json([
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * actualizarPermisosRol
     * SOLO RECIBE UNA LISTA DE ID PERMISOS (OJO SOLO PERMISOS EXISTENTES)
     * YA QUE EL FRONT MANDARA UN JSON CON PERMISOS
     * DESDE POSTMAN SE MANDA UNA SOLICITUD UPDATE CON UN JSON
     * [
     *  {
     *      "permiso_id":1
     *  },
     *  {
     *      "permiso_id":2
     *  }
     * ]
     */
    public function actualizarPermisosRol(Request $request, $idRol)
    {
        try {
            $rolEncontrado = Rol::find($idRol);
            if (!$rolEncontrado) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }
            /*
            $permisosRol = rol_permiso::where('rol_id', $idRol)->get();
            foreach ($permisosRol as $permisoActual) {
                $permisoActual->delete();
            }
                */

            rol_permiso::where('rol_id', $idRol)->delete();    
            //$permisos = $request->all();

            foreach ($request->all() as $permiso) {
                rol_permiso::create([
                    'rol_id' => $idRol,
                    'permiso_id' => $permiso['permiso_id']
                ]);
            }

            

            //return response()->json([$permisos], 201);
            return response()->json(['message' => 'PERMISOS ACTUALIZADOS'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
}
