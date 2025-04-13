<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class UsuarioController extends Controller
{
    public function verUsuarios()
    {
        try {
            $usuarios = User::all();
            return response()->json([$usuarios], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener Usuarios',

            ], 500);
        }
    }

    public function crearUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            /*
            'nombre' => 'required|string|min:2|max:100',
            'apellido' => 'required|string|min:5|max:100',
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|email|min:5|max:50|unique',
            'password' => 'required|min:8',
            'rol_id' => 'required'
            */

            'nombre' => 'required|string|min:2|max:100',
            'apellido' => 'required|string|min:5|max:100', // Corregido: 'apellido'
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|email|min:5|max:50|unique:users,correo', // Añadido tabla
            'password' => 'required|min:8',
            'rol_id' => 'required|exists:roles,id' // Validar que el rol exista
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $nuveoUsuario = new User();
            $nuveoUsuario->nombre = $request->nombre;
            $nuveoUsuario->apellido = $request->apellido;
            $nuveoUsuario->fecha_nacimiento = $request->fecha_nacimiento;
            $nuveoUsuario->correo = $request->correo;
            $nuveoUsuario->password = bcrypt($request->password);
            //$nuveoUsuario->email_verified_at = $request->email_verified_at;
            $nuveoUsuario->rol_id = $request->rol_id;
            $nuveoUsuario->save();
            return response()->json(["message" => 'Usuario Creado'], 201);
        } catch (\Exception $e) {
            //throw $th;

            $errorData = [
                'error' => 'Error en la creación de usuario',
                'code' => 'user_creation_error'
            ];

            // Solo en desarrollo mostrar detalles técnicos
            if (config('app.debug')) {
                $errorData['debug'] = [
                    'message' => $e->getMessage(),
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ];
            }

            return response()->json($errorData, 500);
            //return response()->json(['error'=>'Error Usuario No CREADO', $e], 500);
        }
    }
    public function actualizarUsuario(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:2|max:100',
            'apellido' => 'required|string|min:5|max:100',
            'fecha_nacimiento' => 'required|date',
            //'correo' => 'required|email|min:20|max:50|unique:users,correo',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $usuarioEncontrado = User::find($id);
            if (!$usuarioEncontrado) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Actualizar con los datos del request
            $usuarioEncontrado->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'correo' => $request->correo,
                'password' => bcrypt($request->password),
                'rol_id' => $request->rol_id

            ]);
            return response()->json(['message' => 'Usuario Creado'], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al Actualizar el Usuario',
            ], 500);
        }
    }
    public function eliminarUsuario($id)
    {
        try {
            $usuarioEncontrado = User::find($id);
            if (!$usuarioEncontrado) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            $usuarioEncontrado->delete();
            return response()->json(['message' => 'Usuario Eliminado'], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al Eliminar el Usuario',
            ], 500);
        }
    }
}
