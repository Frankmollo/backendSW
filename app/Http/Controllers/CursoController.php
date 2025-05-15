<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Curso;
use App\Http\Controllers\Controller;
use Exception;

class CursoController extends Controller
{
    public function crearCurso(Request $request){
        $validator = Validator::make($request->all(),
        [
            'titulo' => 'required|string|min:2|max:100',
            'descripcion' => 'required|string|min:2|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio' => 'required|decimal|min:0',
            'descuento' => 'required|decimal|min:0|max:100',
            'docente_id' => 'required|exists:docentes,id',
            'categoria_id' => 'required|exists:categoria,id'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],422);
        }
        try {
            $cursoNuevo = new Curso();
            $cursoNuevo->titulo = $request->titulo;
            $cursoNuevo->descripcion = $request->descripcion;
            $cursoNuevo->imagen = $request->file('imagen')->store('imagenes','public');
            $cursoNuevo->precio = $request->precio;
            $cursoNuevo->descuento = $request->descuento;
            $cursoNuevo->docente_id = $request->docente_id;
            $cursoNuevo->categoria_id = $request->categoria_id;
            $cursoNuevo->save();
            return response()->json([
                'message' => 'Curso creado exitosamente',
                'curso' => $cursoNuevo
            ], 201);
        } catch (\Excepcion $e){
            return response()->json([
                'error' => 'Error al crear el curso'
            ],500);
        }

   }

   public function actualizarCurso(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|min:2|max:100',
            'descripcion' => 'required|string|min:2|max:255',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio' => 'required|decimal|min:0',
            'descuento' => 'required|decimal|min:0|max:100',
            'docente_id' => 'required|exists:docentes,id',
            'categoria_id' => 'required|exists:categoria,id'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],422);
        }
        try{
            $cursoEncontrado = Curso::find($id);
            if(!$cursoEncontrado){
                return response()->json(['error' => 'Curso no encontrado'], 404);
            }
            $cursoEncontrado->update([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'imagen' => $request->file('imagen')->store('imagenes','public'),
                'precio' => $request->precio,
                'descuento' => $request->descuento,
                'docente_id' => $request->docente_id,
                'categoria_id' => $request->categoria_id
            ]);
            return response()->json([
                'message' => 'Curso actualizado exitosamente',
                'curso' => $cursoEncontrado
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al actualizar el curso'
            ],500);
        }
   }

   public function verCursos(){
        try {
            $cursos = Curso::all();
            return response()->json([$cursos], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los cursos'
            ], 500);
        }
   }

   public function eliminarCurso($id){
        try {
            $cursoEncontrado = Curso::find($id);
            if(!$cursoEncontrado){
                return response()->json(['error'=>'Curso no encontrado'],404);
            }else{
                $cursoEncontrado->delete();
                return response()->json(['message'=>'Curso eliminado exitosamente']);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el curso'
            ], 500);
        }
   }

   public function verCursoCategoria($id){
        try {
            $cursos = Curso::where('categoria_id', $id)->get();
            return response()->json([$cursos], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los cursos por categoria'
            ], 500);
        }
   }
    public function verCursoDocente($id){
          try {
                $cursos = Curso::where('docente_id', $id)->get();
                return response()->json([$cursos], 200);
          } catch (Exception $e) {
                return response()->json([
                 'error' => 'Error al obtener los cursos por docente'
                ], 500);
          }
    }
}
