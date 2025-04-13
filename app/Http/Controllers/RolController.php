<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\rol_permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function crearRol(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $rolNuevo = new Rol();
            $rolNuevo->nombre = $request->nombre;
            $rolNuevo->save();
            return response()->json([
                'message' => 'Rol creado exitosamente',
                'user' => $rolNuevo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el Rol',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function actualizarRol(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $rolEncontrado = Rol::find($id);
            if (!$rolEncontrado) {
                return response()->json(['error' => 'Rol no encontrado'], 404);
            }

            // Actualizar con los datos del request
            $rolEncontrado->update([
                'nombre' => $request->nombre
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el Rol',
            ], 500);
        }
    }
    public function getRoles()
    {


        try {
            $roles = Rol::all();
            return response()->json([$roles], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener Roles',

            ], 500);
        }
    }
    public function eliminarRol($id)
    {
        try {
            $roles = Rol::find($id);
            $roles->delete();

            return response()->json(["message"=> 'Rol ELIMINADO'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener Rol',

            ], 500);
        }
    }

    
}
