<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejemplo;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Exception;

class EjemploController extends Controller
{
    public function crearEjemplo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contenido_texto' => 'required|string|max:255',
            'contenido_video' => 'nullable|url',
            'contenido_imagen' => 'nullable|url',
            'contenido_audio' => 'nullable|url',
            'tema_id' => 'required|exists:temas,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $ejemploNuevo = new Ejemplo();
            $ejemploNuevo->contenido_texto = $request->contenido_texto;
            $ejemploNuevo->contenido_video = $request->contenido_video;
            $ejemploNuevo->contenido_imagen = $request->contenido_imagen;
            $ejemploNuevo->contenido_audio = $request->contenido_audio;
            $ejemploNuevo->tema_id = $request->tema_id;
            $ejemploNuevo->save();
            return response()->json([
                'message' => 'Ejemplo creado exitosamente',
                'ejemplo' => $ejemploNuevo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el ejemplo',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function actualizarEjemplo(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'contenido_texto' => 'required|string|max:255',
            'contenido_video' => 'nullable|url',
            'contenido_imagen' => 'nullable|url',
            'contenido_audio' => 'nullable|url',
            'tema_id' => 'required|exists:temas,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $ejemploEncontrado = Ejemplo::find($id);
            if (!$ejemploEncontrado) {
                return response()->json(['error' => 'Ejemplo no encontrado'], 404);
            }

            // Actualizar con los datos del request
            $ejemploEncontrado->update([
                'contenido_texto' => $request->contenido_texto,
                'contenido_video' => $request->contenido_video,
                'contenido_imagen' => $request->contenido_imagen,
                'contenido_audio' => $request->contenido_audio,
                'tema_id' => $request->tema_id
            ]);
            return response()->json([
                'message' => 'Ejemplo actualizado exitosamente',
                'ejemplo' => $ejemploEncontrado
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el ejemplo',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function verEjemplos()
    {
        try {
            $ejemplos = Ejemplo::all();
            return response()->json([$ejemplos], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los ejemplos',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function eliminarEjemplo($id)
    {
        try {
            $ejemploEncontrado = Ejemplo::find($id);
            if (!$ejemploEncontrado) {
                return response()->json(['error' => 'Ejemplo no encontrado'], 404);
            }
            $ejemploEncontrado->delete();
            return response()->json([
                'message' => 'Ejemplo eliminado exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el ejemplo',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function verEjemploTema($tema_id)
    {
        try {
            $ejemplos = Ejemplo::where('tema_id', $tema_id)->get();
            return response()->json([$ejemplos], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los ejemplos por tema',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
}
