<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:5|max:100',
            'apellido' => 'required|string|min:5|max:100',
            'fecha_nacimiento' => 'required|date|min:5|max:100',
            'correo' => 'required|string|email|min:5|max:100|unique:users',
            'password' => 'required|string|min:10|confirmed',
            'role' => 'required|string|in:admin,user'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        User::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'fecha_nacimiento' => $request->get('fecha_nacimiento'),
            'correo' => $request->get('correo'),
            'password' => bcrypt($request->get('password')),
            'role' => $request->get('role'),
        ]);
        return response()->json(['message' => 'Usuario Creado Exitosamente'], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'correo' => 'required|string|email|min:5|max:100',
            'password' => 'required|string|min:10',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $credenciales = $request->only('correo', 'password');
        try {
            if (!$token = JWTAuth::attempt($credenciales)) {
                return response()->json(['error' => 'Credenciales Invalidas'], 401);
            }
            return response()->json(['token' => $token], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo Generar el TOKEN', $e], 500);
        }
    }

    public function getUser()
    {
        $usuario = Auth::user();
        return response()->json([$usuario], 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Session cerrada con EXITO'], 200);
    }

    public function getUsers()
    {
        $usuarios = User::all();
        return response()->json([$usuarios], 200);
    }

    public function registroAdmin(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:5|max:100',
            'apellido' => 'required|string|min:5|max:100',
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|string|email|min:5|max:100|unique:users',
            'password' => 'required|string|min:10|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        

        try {
            // Obtener el rol Admin correctamente
            $rolAdmin = Rol::where('nombre', 'Admin')->first()->id;

            if (!$rolAdmin) {
                return response()->json(['error' => 'Rol Admin no encontrado'], 404);
            }

            // Crear el usuario
            /*$user = User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'correo' => $request->correo,
                'password' => bcrypt($request->password),
                'rol_id' => 1, // Usar el ID del rol encontrado
            ]);*/
            $user = new User();
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->correo = $request->correo;
            $user->fecha_nacimiento=$request->fecha_nacimiento;
            $user->password = $request->password;
            $user->rol_id = $rolAdmin;
            $user->save();
            //$user->

            return response()->json([
                'message' => 'Usuario administrador creado exitosamente',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el usuario',
                
            ], 500);
        }
    }
}
