<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class EquipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function Equipo()
    {
        try {
            return view('equipo.equipo');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function GetEquipo()
    {
        try {

            $response = DB::select("CALL sp_listar_equipo()");

            $result = collect($response)->map(function ($item) {
                return [
                    'Id'             => $item->id,
                    'Dni'            => $item->dni,
                    'Nombres'        => $item->nombres,
                    'ApellidoPaterno' => $item->apellido_paterno,
                    'ApellidoMaterno' => $item->apellido_materno,
                    'IdDepartamento' => $item->id_departamento,
                    'Departamento'   => $item->departamento,
                    'IdProvincia'    => $item->id_provincia,
                    'Provincia'      => $item->provincia,
                    'IdDistrito'     => $item->id_distrito,
                    'Distrito'       => $item->distrito,
                    'Direccion'      => $item->direccion,
                    'Correo'         => $item->correo,
                    'Telefono'       => $item->telefono,
                    'Cargo'          => $item->cargo
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarIntegrante(Request $request)
    {
        try {

            $user = Auth::user();

            $request->validate([
                'dni' => 'required|string|max:20',
                'nombres' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
                'id_departamento' => 'nullable|integer',
                'id_provincia' => 'nullable|integer',
                'id_distrito' => 'nullable|integer',
                'direccion' => 'nullable|string|max:255',
                'correo' => 'required|email|max:100',
                'telefono' => 'required|string|max:15',
                'cargo' => 'required|string|max:100',
            ]);

            $params = [
                'p_dni' => $request->input('dni'),
                'p_nombres' => $request->input('nombres'),
                'p_apellidoPaterno' => $request->input('apellido_paterno'),
                'p_apellidoMaterno' => $request->input('apellido_materno'),
                'p_idDepartamento' => $request->input('id_departamento') ?? null,
                'p_idProvincia' => $request->input('id_provincia') ?? null,
                'p_idDistrito' => $request->input('id_distrito') ?? null,
                'p_direccion' => $request->input('direccion') ?? null,
                'p_telefono' => $request->input('telefono') ?? null,
                'p_correo' => $request->input('correo') ?? null,
                'p_cargo' => $request->input('cargo'),
                'p_password' => Hash::make($request->input('dni')),
                'p_usuario' => $user->email
            ];

            DB::statement("SET @Msj = '', @Msj2 = ''");

            DB::select(
                'CALL sp_registrar_integranteEquipo(
                    :p_dni,
                    :p_nombres,
                    :p_apellidoPaterno,
                    :p_apellidoMaterno,
                    :p_idDepartamento,
                    :p_idProvincia,
                    :p_idDistrito,
                    :p_direccion,
                    :p_telefono,
                    :p_correo,
                    :p_cargo,
                    :p_password,
                    :p_usuario,
                    @Msj,
                    @Msj2
                )',
                $params
            );

            $result = DB::select('SELECT @Msj AS Msj, @Msj2 AS Msj2')[0];

            return response()->json(['status' => 'success', 'Msj' => $result->Msj, 'Msj2' => $result->Msj2], Response::HTTP_OK);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarIntegrante($id)
    {
        try {

            $response = Equipo::where('id', $id)->where('estado_registro', 1)->first();

            $result = [
                'Id'             => $response->id,
                'Dni'            => $response->dni,
                'Nombres'        => $response->nombres,
                'ApellidoPaterno' => $response->apellido_paterno,
                'ApellidoMaterno' => $response->apellido_materno,
                'IdDepartamento' => $response->id_departamento,
                'Departamento'   => $response->departamento,
                'IdProvincia'    => $response->id_provincia,
                'Provincia'      => $response->provincia,
                'IdDistrito'     => $response->id_distrito,
                'Distrito'       => $response->distrito,
                'Direccion'      => $response->direccion,
                'Correo'         => $response->correo,
                'Telefono'       => $response->telefono,
                'Cargo'          => $response->cargo
            ];

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ActualizarIntegrante(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|integer',
                'dni' => 'required|string|max:20',
                'nombres' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
                'id_departamento' => 'nullable|integer',
                'id_provincia' => 'nullable|integer',
                'id_distrito' => 'nullable|integer',
                'direccion' => 'nullable|string|max:255',
                'correo' => 'nullable|email|max:100',
                'telefono' => 'nullable|string|max:15',
                'cargo' => 'required|string|max:100',
            ]);

            $params = [
                'p_id' => $request->input('id'),
                'p_dni' => $request->input('dni'),
                'p_nombres' => $request->input('nombres'),
                'p_apellidoPaterno' => $request->input('apellido_paterno'),
                'p_apellidoMaterno' => $request->input('apellido_materno'),
                'p_idDepartamento' => $request->input('id_departamento') ?? null,
                'p_idProvincia' => $request->input('id_provincia') ?? null,
                'p_idDistrito' => $request->input('id_distrito') ?? null,
                'p_direccion' => $request->input('direccion') ?? null,
                'p_correo' => $request->input('correo') ?? null,
                'p_telefono' => $request->input('telefono') ?? null,
                'p_cargo' => $request->input('cargo')
            ];

            DB::statement("SET @Msj = '', @Msj2 = ''");

            DB::select(
                'CALL sp_actualizar_integranteEquipo(
                    :p_id,
                    :p_dni,
                    :p_nombres,
                    :p_apellidoPaterno,
                    :p_apellidoMaterno,
                    :p_idDepartamento,
                    :p_idProvincia,
                    :p_idDistrito,
                    :p_direccion,
                    :p_correo,
                    :p_telefono,
                    :p_cargo,
                    @Msj,
                    @Msj2
                )',
                $params
            );

            $result = DB::select('SELECT @Msj AS Msj, @Msj2 AS Msj2')[0];

            return response()->json(['status' => 'success', 'Msj' => $result->Msj, 'Msj2' => $result->Msj2], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EliminarIntegrante(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            $integrante = Equipo::findOrFail($request->input('id'));
            $integrante->estado_registro = 2;
            $integrante->save();

            $usuario = User::find($integrante->id_usuario);
            $usuario->estado_registro = 2;
            $usuario->save();

            return response()->json(['status' => 'success', 'Msj' => 'INTEGRANTE ELIMINADO CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}