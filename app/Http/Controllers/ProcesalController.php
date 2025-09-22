<?php

namespace App\Http\Controllers;

use App\Models\Comunicacion;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProcesalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function Procesales()
    {
        try {
            return view('procesales.procesales');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function GetProcesales()
    {
        try {

            $response = DB::select("CALL sp_listar_procesales(null)");

            $result = collect($response)->map(function ($item) {
                return [
                    'IdPersona'       => $item->id_persona,
                    'TipoPersona'     => $item->tipo_persona,
                    'TipoProcesal'    => $item->tipo_procesal,
                    'Condicion'       => $item->condicion,
                    'Documento'       => $item->documento,
                    'DatosProcesal'   => $item->datos,
                    'IdDepartamento'  => $item->id_departamento,
                    'Departamento'    => $item->departamento,
                    'IdProvincia'  => $item->id_provincia,
                    'Provincia'    => $item->provincia,
                    'IdDistrito'  => $item->id_distrito,
                    'Distrito'    => $item->distrito
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ProcesalDetalle($id)
    {
        try {

            $result = $this->getProcesalById($id);

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ProcesalEditar($id)
    {
        try {

            $result = $this->getProcesalById($id);

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ProcesalActualizar(Request $request)
    {
        try {

            $request->validate([
                'IdProcesal' => 'required|integer|exists:personas,id',
                'TipoPersona' => 'required|in:NATURAL,JURIDICA',
                'TipoProcesal' => 'required|string|max:100',
                'Condicion' => 'required|string|max:100'
            ]);

            $params = [
                'p_idProcesal' => $request->input('IdProcesal'),
                'p_idExpediente' => $request->input('IdExpediente'),
                'p_tipoPersona' => $request->input('TipoPersona'),
                'p_tipoProcesal' => $request->input('TipoProcesal'),
                'p_condicion' => $request->input('Condicion'),
                'p_dni' => $request->input('Dni'),
                'p_nombre' => $request->input('Nombres'),
                'p_aPaterno' => $request->input('APaterno'),
                'p_aMaterno' => $request->input('AMaterno'),
                'p_ruc' => $request->input('Ruc'),
                'p_razonSocial' => $request->input('RazonSocial'),
                'p_idDepartamento' => $request->input('IdDepartamento'),
                'p_idProvincia' => $request->input('IdProvincia'),
                'p_idDistrito' => $request->input('IdDistrito'),
                'p_calle' => $request->input('Direccion'),
                'p_telefono' => $request->input('Telefono'),
                'p_correo' => $request->input('Correo'),
            ];

            DB::statement("SET @Msj = '', @Msj2 = ''");

            DB::select(
                'CALL sp_editar_procesal(
                    :p_idProcesal,
                    :p_idExpediente,
                    :p_tipoPersona,
                    :p_tipoProcesal,
                    :p_condicion,
                    :p_dni,
                    :p_nombre,
                    :p_aPaterno,
                    :p_aMaterno,
                    :p_ruc,
                    :p_razonSocial,
                    :p_idDepartamento,
                    :p_idProvincia,
                    :p_idDistrito,
                    :p_calle,
                    :p_telefono,
                    :p_correo,
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

    public function ProcesalExpedientes(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:personas,id',
            ]);

            $id = $request->query('id');
            $result = DB::select('CALL sp_expedientes_persona(?)', [$id]);

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarComunicacion(Request $request)
    {
        try {

            $user = Auth::user();

            $request->validate([
                'id_expediente' => 'required|integer|exists:expedientes,id',
                'medio' => 'required|string|max:100',
            ]);

            $comunicacion = new Comunicacion;

            $comunicacion->id_persona = $request->input('id_persona');
            $comunicacion->id_expediente = $request->input('id_expediente');
            $comunicacion->medio = $request->input('medio');
            $comunicacion->descripcion = $request->input('descripcion');
            $comunicacion->usuario = $user->email;

            $comunicacion->save();

            return response()->json(['status' => 'success', 'Msj' => 'COMUNICACION REGISTRADA CORRECTAMENTE'], Response::HTTP_CREATED);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ListarComunicaciones()
    {
        try {

            $comunicaciones = DB::select('CALL sp_listar_comunicaciones()');

            $result = collect($comunicaciones)->map(function ($co) {
                return [
                    'id'            => $co->id,
                    'documento'     => $co->documento,
                    'persona'       => $co->persona,
                    'expediente'    => $co->expediente,
                    'medio'         => $co->medio,
                    'descripcion'   => $co->descripcion,
                    'fechaRegistro' => FormatearFechaLarga($co->fecha_registro),
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getProcesalById($id)
    {
        $response = DB::select("CALL sp_listar_procesales(?)", [$id]);
        $item = $response[0] ?? null;

        if (!$item) {
            return null;
        }

        return [
            'IdPersona'      => $item->id_persona,
            'TipoPersona'    => $item->tipo_persona,
            'TipoProcesal'   => $item->tipo_procesal,
            'Condicion'      => $item->condicion,
            'Dni'            => $item->dni,
            'Nombres'        => $item->nombres,
            'APaterno'       => $item->apellido_paterno,
            'AMaterno'       => $item->apellido_materno,
            'Ruc'            => $item->ruc,
            'RazonSocial'    => $item->razon_social,
            'Documento'      => $item->documento,
            'DatosProcesal'  => $item->datos,
            'IdDepartamento' => $item->id_departamento,
            'Departamento'   => $item->departamento,
            'IdProvincia'    => $item->id_provincia,
            'Provincia'      => $item->provincia,
            'IdDistrito'     => $item->id_distrito,
            'Distrito'       => $item->distrito,
            'Direccion'      => $item->direccion,
            'Telefono'       => $item->telefono,
            'Correo'         => $item->correo,
        ];
    }
}
