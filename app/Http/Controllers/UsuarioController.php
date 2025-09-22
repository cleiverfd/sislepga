<?php

namespace App\Http\Controllers;

use App\Models\RecursoSistema;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function listar_Usuarios()
    {
        try {
            return view('usuarios.usuario-listar');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function GetUsuarios()
    {
        try {
            $usuarios = DB::select("CALL sp_listar_usuarios");

            $result = collect($usuarios)->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Dni' => $item->dni ?? '',
                    'Nombre' => $item->nombre,
                    'Email' => $item->email,
                    'Rol' => $item->rol ?? 'SIN_ROL',
                    'Estado' => $item->estado_registro ?? 1,
                    'FechaRegistro' => FormatearFechaLarga($item->fecha_registro)
                ];
            });
            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required|string|min:8|max:8|unique:usuarios,dni',
            'nombre' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:usuarios,email',
            'rol' => 'required|string|in:ABOGADO,SECRETARIA,PRACTICANTE',
        ], [
            'dni.required' => 'El DNI es requerido',
            'dni.min' => 'El DNI debe tener exactamente 8 dígitos',
            'dni.max' => 'El DNI debe tener exactamente 8 dígitos',
            'dni.unique' => 'Este DNI ya está registrado',
            'nombre.required' => 'El nombre es requerido',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El formato del email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'rol.required' => 'El rol es requerido',
            'rol.in' => 'El rol seleccionado no es válido',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }

            $user = new User();
            $user->dni = $request->input('dni');
            $user->nombre = ucwords(strtoupper(trim($request->input('nombre'))));
            $user->email = strtolower(trim($request->input('email')));
            $user->rol = strtoupper(trim($request->input('rol')));
            $user->password = Hash::make($request->input('dni'));
            $user->estado_registro = 1;
            $user->save();

            return response()->json(['status' => 'success', 'Msj' => 'Usuario registrado correctamente'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'Msj' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Get_EditarUsuario(Request $request)
    {
        try {
            $id = $request->query('IdUsuario');

            if (!$id) {
                return response()->json(['status' => 'error', 'message' => 'ID de usuario requerido'], Response::HTTP_BAD_REQUEST);
            }

            $usuario = User::where('id', $id)
                ->where('estado_registro', 1)
                ->first();

            if ($usuario) {
                $result = [
                    'id' => $usuario->id,
                    'dni' => $usuario->dni ?? '',
                    'nombre' => $usuario->nombre,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol ?? ''
                ];
                return response()->json(['status' => 'success', 'data' => [$result]], Response::HTTP_OK);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdUsuario' => 'required|integer|exists:usuarios,id',
            'Nombre' => 'required|string|max:255|min:3',
            'Correo' => 'required|email',
            'Rol' => 'required|string',
            'Estado' => 'nullable|integer|in:1,2',
        ], [
            'IdUsuario.required' => 'ID de usuario requerido',
            'IdUsuario.exists' => 'Usuario no encontrado',
            'Nombre.required' => 'El nombre es requerido',
            'Nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'Correo.required' => 'El email es requerido',
            'Correo.email' => 'El formato del email no es válido',
            'Rol.required' => 'El rol es requerido',
            'Rol.in' => 'El rol seleccionado no es válido',
            'Estado.required' => 'El estado es requerido',
            'Estado.in' => 'El estado seleccionado no es válido',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }

            $idUsuario = $request->input('IdUsuario');
            $usuario = User::find($idUsuario);

            if (!$usuario) {
                return response()->json(['status' => 'error', 'Msj' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
            }

            // Verificar si el email ya existe en otro usuario
            $emailExists = User::where('email', $request->input('Correo'))
                ->where('id', '!=', $idUsuario)
                ->exists();

            if ($emailExists) {
                return response()->json(['status' => 'error', 'errors' => ['Correo' => ['Este email ya está registrado por otro usuario']]], 422);
            }

            $usuario->nombre = strtoupper(trim($request->input('Nombre')));
            $usuario->email = strtolower(trim($request->input('Correo')));
            $usuario->rol = strtoupper(trim($request->input('Rol')));
            $usuario->save();

            return response()->json(['status' => 'success', 'Msj' => 'Usuario actualizado correctamente'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'Msj' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EliminarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdUsuario' => 'required|integer|exists:usuarios,id',
        ], [
            'IdUsuario.required' => 'ID de usuario requerido',
            'IdUsuario.exists' => 'Usuario no encontrado',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }

            $idUsuario = $request->input('IdUsuario');
            $usuario = User::find($idUsuario);

            if (!$usuario) {
                return response()->json(['status' => 'error', 'Msj' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
            }

            // Verificar si el usuario es el administrador principal
            if ($usuario->id === 1) {
                return response()->json(['status' => 'error', 'Msj' => 'No se puede desactivar el usuario administrador principal'], Response::HTTP_FORBIDDEN);
            }

            $usuario->estado_registro = 2;
            $usuario->save();

            return response()->json(['status' => 'success', 'Msj' => 'Usuario desactivado correctamente'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'Msj' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function listarRecursos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:usuarios,id',
        ], [
            'id.required' => 'ID de usuario requerido',
            'id.exists' => 'Usuario no encontrado',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }

            $idUsuario = $request->input('id');
            $recursos = DB::select("CALL sp_listarRecursosUsuario(?)", [$idUsuario]);

            $result = collect($recursos)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'descripcion' => $item->descripcion,
                    'permiso' => (bool) $item->permiso,
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function AsignarRecursos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdUsuario' => 'required|integer|exists:usuarios,id',
            'Permisos' => 'required|array',
            'Permisos.*' => 'integer|exists:recursos_sistema,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'Msj2' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $idUsuario = $request->input('IdUsuario');
        $permisos = $request->input('Permisos');
        $usuarioAccion = auth()->user()->email ?? 'SYSTEM';

        try {
            // Convertir array a CSV
            $csv = implode(',', $permisos);

            DB::statement("CALL sp_asignar_recursos_usuario(?, ?, ?)", [$idUsuario, $csv, $usuarioAccion]);

            return response()->json(['status' => 'success', 'Msj' => 'Permisos asignados correctamente'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Error interno del servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
