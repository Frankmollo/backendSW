<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
Use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TemaController extends Controller
{
    public function crearTema(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|min:2|max:100',
            'descripcion' => 'required|string|min:2|max:255',
            'curso_id' => 'required|integer|exists:curso,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $temaNuevo = new Tema();
            $temaNuevo->titulo = $request->titulo;
            $temaNuevo->descripcion = $request->descripcion;
            $temaNuevo->curso_id = $request->curso_id;
            $temaNuevo->save();
            return response()->json([
                'message' => 'Tema creado exitosamente',
                'user' => $temaNuevo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el Tema',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }


    public function actualizarTema(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|min:2|max:100',
            'descripcion' => 'required|string|min:2|max:255',
            'curso_id' => 'required|integer|exists:curso,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $temaEncontrado = Tema::find($id);
            if (!$temaEncontrado) {
                return response()->json(['error' => 'Tema no encontrado'], 404);
            }

            // Actualizar con los datos del request
            $temaEncontrado->update([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'curso_id' => $request->curso_id
            ]);
            return response()->json([
                'message' => 'Tema actualizado exitosamente',
                'user' => $temaEncontrado
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el Tema',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function verTemas(){
        try {
            $temas = Tema::all();
            return response()->json([$temas], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los temas',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function eliminarTema($id)
    {
        try {
            $temaEncontrado = Tema::find($id);
            if (!$temaEncontrado) {
                return response()->json(['error' => 'Tema no encontrado'], 404);
            }
            $temaEncontrado->delete();
            return response()->json(['message' => 'Tema eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el Tema',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function verTemaCurso($curso_id)
    {
        try {
            $temas = Tema::where('curso_id', $curso_id)->get();
            return response()->json([$temas], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los temas por curso',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
}
