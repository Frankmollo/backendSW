<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Exception;

class CategoriaController extends Controller
{
    public function crearCategoria(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:100',
            'descripcion' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $categoriaNueva = new Categoria();
            $categoriaNueva->nombre = $request->nombre;
            $categoriaNueva->descripcion = $request->descripcion;
            $categoriaNueva->save();
            return response()->json([
                'message' => 'Categoria creada exitosamente',
                'user' => $categoriaNueva
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear la Categoria',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function actualizarCategoria(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:100',
            'descripcion' => 'required|string|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $categoriaEncontrada = Categoria::find($id);
            if (!$categoriaEncontrada) {
                return response()->json(['error' => 'Categoria no encontrada'], 404);
            }

            // Actualizar con los datos del request
            $categoriaEncontrada->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear la Categoria',
                //'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function verCategorias(){
        try {
            $categorias = Categoria::all();
            return response()->json([$categorias],200);
        } catch(Exception $e){
            return response()->json([
                'error' => 'Error al obtener las categorias'
            ],500);
        }
    }

    public function eliminarCategoria($id){
        try {
            $categoriaEncontrada = Categoria::find($id);
            if(!$categoriaEncontrada){
                return response()->json(['error'=>'Categoria no encontrada'],404);
            }else{
                $categoriaEncontrada->delete();
                return response()->json(['message'=>'Categoria eliminada exitosamente']);
            }
        } catch (Excepcion $e){
            return response()->json([
                'error'=> 'Error al eliminar la categoria'
            ],500);
        }
    }
}
