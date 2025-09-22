<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Audiencia;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\DistritoJudicial;
use App\Models\DocumentoLegal;
use App\Models\Especialidad;
use App\Models\Expediente;
use App\Models\Fiscalia;
use App\Models\Instancia;
use App\Models\Juzgado;
use App\Models\Materia;
use App\Models\Persona;
use App\Models\Pretension;
use App\Models\Provincia;
use App\Models\VwExpedienteDetalle;
use App\Models\Abogado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;
use Throwable;

class ExpedienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function listar_ExpedientesCivil()
    {
        try {
            return view('expedientes.expedientes-civil');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function listar_ExpedientesPenal()
    {
        try {
            return view('expedientes.expedientes-penal');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function registrar_ExpedienteCivil()
    {
        try {
            return view('expedientes.registrar-civil');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function registrar_ExpedientePenal()
    {
        try {
            return view('expedientes.registrar-penal');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function GetExpedientes(Request $request)
    {
        Carbon::setLocale('es');
        try {

            $idTipoExpediente = $request->query('IdTipoExpediente');
            $idEstadoExpediente = $request->query('IdEstadoExpediente');
            $idPretension = $request->query('IdPretension');

            $response = DB::select("CALL sp_listar_expedientes(?,?,?)", [$idTipoExpediente, $idEstadoExpediente, $idPretension]);

            $result = collect($response)->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Numero' => $item->numero,
                    'FechaInicio' => formatearFechaCorta($item->fecha_inicio),
                    'Pretension' => $item->pretension,
                    'FechaRegistro' => FormatearFechaLarga($item->fecha_registro),
                    'IdEstadoExpediente' => $item->id_estado_expediente,
                    'EstadoExpediente' => $item->estado_expediente,
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetAbogados(Request $request)
    {
        try {

            $abogados = Abogado::where('estado_registro', 1)->get();

            $result = $abogados->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->dni . '-' . $item->nombres . ' ' . $item->apellido_paterno . ' ' . $item->apellido_materno,
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetPretensiones(Request $request)
    {
        try {
            $IdTipoExpediente = $request->query('IdTipoExpediente');
            $pretension = Pretension::where('id_tipo_expediente', $IdTipoExpediente)->get();

            $result = $pretension->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'IdTipoExpediente' => $item->id_tipo_expediente,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetMaterias(Request $request)
    {
        try {
            $IdTipoExpediente = $request->query('IdTipoExpediente');
            $response = Materia::where('id_tipo_expediente', $IdTipoExpediente)->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'IdTipoExpediente' => $item->id_tipo_expediente,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetDistritosJudiciales()
    {
        try {
            $response = DistritoJudicial::has('juzgados')->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetInstancias(Request $request)
    {
        try {
            $IdTipoExpediente = $request->query('IdTipoExpediente');
            $response = Instancia::where('estado_registro', 1)->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'IdTipoExpediente' => $item->id_tipo_expediente,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetEspecialidades(Request $request)
    {
        try {
            $response = Especialidad::all();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Id_TipoExpediente' => $item->id_tipo_expediente,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetJuzgados(Request $request)
    {
        try {
            $IdTipoExpediente = $request->query('IdTipoExpediente');
            $IdDJudicial = $request->query('IdDJudicial');
            $response = Juzgado::where('id_tipo_expediente', $IdTipoExpediente)->where('id_distrito_judicial', $IdDJudicial)->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Id_TipoExpediente' => $item->id_tipo_expediente,
                    'Id_DistritoJudicial' => $item->id_distrito_judicial,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetFiscalias(Request $request)
    {
        try {
            $IdTipoExpediente = $request->query('IdTipoExpediente');
            $IdDJudicial = $request->query('IdDJudicial');
            $response = Fiscalia::where('id_distrito_judicial', $IdDJudicial)->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Id_TipoExpediente' => $item->id_tipo_expediente,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json($result, Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetDepartamentos()
    {
        try {
            $response = Departamento::all();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetProvincias(Request $request)
    {
        try {
            $idDepartamento = $request->query('idDepartamento');
            $response = Provincia::where('id_departamento', $idDepartamento)->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Id_Departamento' => $item->id_departamento,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetDistritos(Request $request)
    {
        try {
            $idProvincia = $request->query('idProvincia');
            $response = Distrito::where('id_provincia', $idProvincia)->get();

            $result = $response->map(function ($item) {
                return [
                    'Id' => $item->id,
                    'Id_Provincia' => $item->id_provincia,
                    'Descripcion' => $item->descripcion
                ];
            });
            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetBuscarPersona(Request $request)
    {
        try {
            $tipoPersona = $request->query('tipoPersona');
            $documento = $request->query('documento');
            $response = DB::select("CALL sp_buscar_persona(?, ?)", [$tipoPersona, $documento]);

            $result = collect($response)->map(function ($item) {
                return [
                    'Id' => $item->id ?? null,
                    'Dni' => $item->dni ?? null,
                    'Nombre' => $item->nombres ?? null,
                    'APaterno' => $item->apellido_paterno ?? null,
                    'AMaterno' => $item->apellido_materno ?? null,
                    'Ruc' => $item->ruc ?? null,
                    'RazonSocial' => $item->razon_social ?? null,
                    'TipoPersona' => $item->tipo_persona ?? null,
                    'TipoProcesal' => $item->tipo_procesal ?? null,
                    'Condicion' => $item->condicion ?? null,
                    'IdDepartamento' => $item->id_departamento ?? null,
                    'IdProvincia' => $item->id_provincia ?? null,
                    'IdDistrito' => $item->id_distrito ?? null,
                    'CalleAv' => $item->direccion ?? null
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function obtenerDatosExpediente($id)
    {
        $item = Expediente::findOrFail($id);

        return [
            'id' => $item->id,
            'numero' => $item->numero,
            'carpeta_fiscal' => $item->carpeta_fiscal,
            'contrato_referencia' => $item->contrato_referencia,
            'fecha_inicio' => Carbon::parse($item->fecha_inicio)->format('Y-m-d'),
            'id_pretension' => $item->id_pretension,
            'id_materia' => $item->id_materia,
            'id_distrito_judicial' => $item->id_distrito_judicial,
            'id_instancia' => $item->id_instancia,
            'id_especialidad' => $item->id_especialidad,
            'id_juzgado' => $item->id_juzgado,
            'id_fiscalia' => $item->id_fiscalia,
            'id_abogado' => $item->id_abogado,
            'id_estado_expediente' => $item->id_estado_expediente,
            'estado_expediente' => $item->estado_expediente,
            'id_tipo_expediente' => $item->id_tipo_expediente,
            'monto_pretension' => $item->monto_pretension,
            'total_sentencia' => $item->total_sentencia,
            'saldo_total' => $item->saldo_total,
            'fecha_registro' => $item->fecha_registro,
            'fecha_actualizacion' => $item->fecha_actualizacion,
        ];
    }

    public function RegistrarExpediente(Request $request)
    {

        $user = Auth::user();

        $params = [
            'p_numero'         => $request->input('Numero') ?? null,
            'p_carpeta'        => $request->input('Carpeta') ?? null,
            'p_contrato'       => $request->input('Contrato') ?? null,
            'p_fechaInicio'    => $request->input('Fecha_Inicio') ?? null,
            'p_idPretension'   => $request->input('Id_Pretension') ?? null,
            'p_montoPretension' => $request->input('Monto_Pretension') ?? null,
            'p_idMateria'      => $request->input('Id_Materia') ?? null,
            'p_idDJudicial'    => $request->input('Id_DJudicial') ?? null,
            'p_idInstancia'    => $request->input('Id_Instancia') ?? null,
            'p_idFiscalia'     => $request->input('Id_Fiscalia') ?? null,
            'p_idEspecialidad' => $request->input('Id_Especialidad') ?? null,
            'p_idJuzgado'      => $request->input('Id_Juzgado') ?? null,
            'p_idAbogado'      => $request->input('Id_Abogado') ?? null,
            'p_idEstado'       => $request->input('Id_EstadoExpediente') ?? null,
            'p_idTipo'         => $request->input('Id_TipoExpediente') ?? null,
            'p_totalSentencia' => $request->input('Monto_Sentencia') ?? null,
            'p_saldoTotal'     => $request->input('Saldo_Total') ?? null,
            'p_usuario' => $user->email
        ];

        try {

            DB::statement("SET @IdExpediente = 0, @Msj = '', @Msj2 = ''");

            DB::select(
                'CALL sp_registrar_expediente(
                    :p_numero,
                    :p_carpeta,
                    :p_contrato,
                    :p_fechaInicio,
                    :p_idPretension,
                    :p_montoPretension,
                    :p_idMateria,
                    :p_idDJudicial,
                    :p_idInstancia,
                    :p_idFiscalia,
                    :p_idEspecialidad,
                    :p_idJuzgado,
                    :p_idAbogado,
                    :p_idEstado,
                    :p_idTipo,
                    :p_totalSentencia,
                    :p_saldoTotal,
                    :p_usuario,
                    @IdExpediente,
                    @Msj,
                    @Msj2
                )',
                $params
            );

            $result = DB::select('SELECT @IdExpediente AS IdExpediente, @Msj AS Msj, @Msj2 AS Msj2')[0];

            return response()->json(['status' => 'success', 'Msj' => $result->Msj, 'Msj2' => $result->Msj2, 'IdExpediente' => $result->IdExpediente], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ListarExpediente(Request $request)
    {
        $expediente = $this->obtenerDatosExpediente($request->input('id'));
        try {
            return response()->json(['status' => 'success', 'Expediente' => $expediente], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarProcesal(Request $request)
    {
        try {

            $user = Auth::user();

            $request->validate([
                'IdExpediente' => 'required|integer|exists:expedientes,id',
                'TipoPersona' => 'required|in:NATURAL,JURIDICA',
                'TipoProcesal' => 'required|string|max:100',
                'Condicion' => 'required|string|max:100'
            ]);

            $params = [
                'p_idExpediente' => $request->input('IdExpediente'),
                'p_tipoPersona' => $request->input('TipoPersona'),
                'p_tipoProcesal' => $request->input('TipoProcesal'),
                'p_condicion' => $request->input('Condicion'),
                'p_dni' => $request->input('Dni'),
                'p_nombre' => $request->input('Nombre'),
                'p_aPaterno' => $request->input('APaterno'),
                'p_aMaterno' => $request->input('AMaterno'),
                'p_ruc' => $request->input('Ruc'),
                'p_razonSocial' => $request->input('RazonSocial'),
                'p_idDepartamento' => $request->input('IdDepartamento'),
                'p_idProvincia' => $request->input('IdProvincia'),
                'p_idDistrito' => $request->input('IdDistrito'),
                'p_calle' => $request->input('Calle'),
                'p_usuario' => $user->email
            ];

            DB::statement("SET @Msj = '', @Msj2 = ''");

            DB::select(
                'CALL sp_registrar_procesal(
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
                    :p_usuario,
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

    public function ListarProcesales(Request $request)
    {
        try {
            $idExpediente = $request->input('IdExpediente');

            $response = DB::select("CALL sp_procesales_por_expediente(?)", [$idExpediente]);

            $result = collect($response)->map(function ($item) {
                return [
                    'IdExpediente'    => $item->id_expediente,
                    'IdProcesal'      => $item->id_procesal,
                    'IdPersona'       => $item->id_personas,
                    'TipoPersona'     => $item->tipo_persona,
                    'TipoProcesal'    => $item->tipo_procesal,
                    'Condicion'       => $item->condicion,
                    'Documento'       => $item->documento,
                    'DatosProcesal'   => $item->datos_procesal,
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Get_EditarProcesal(Request $request)
    {
        try {
            $idProcesal = $request->query('IdProcesal');

            $item = Persona::findOrFail($idProcesal);

            $procesal = [
                'Id' => $item->id,
                'Dni' => $item->dni,
                'APaterno' => $item->apellido_paterno,
                'AMaterno' => $item->apellido_materno,
                'Nombre' => $item->nombres,
                'Ruc' => $item->ruc,
                'RazonSocial' => $item->razon_social,
                'IdDepartamento' => $item->id_departamento,
                'IdProvincia' => $item->id_provincia,
                'IdDistrito' => $item->id_distrito,
                'CalleAv' => $item->direccion,
                'TipoProcesal' => $item->tipo_procesal,
                'TipoPersona' => $item->tipo_persona,
                'Condicion' => $item->condicion
            ];

            return response()->json(['status' => 'success', 'data' => $procesal], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarProcesal(Request $request)
    {
        try {

            $request->validate([
                'IdProcesal' => 'required|integer|exists:personas,id',
                'IdExpediente' => 'required|integer|exists:expedientes,id',
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
                'p_nombre' => $request->input('Nombre'),
                'p_aPaterno' => $request->input('APaterno'),
                'p_aMaterno' => $request->input('AMaterno'),
                'p_ruc' => $request->input('Ruc'),
                'p_razonSocial' => $request->input('RazonSocial'),
                'p_idDepartamento' => $request->input('IdDepartamento'),
                'p_idProvincia' => $request->input('IdProvincia'),
                'p_idDistrito' => $request->input('IdDistrito'),
                'p_calle' => $request->input('Calle'),
                'p_telefono' => $request->input('Telefono')?? null,
                'p_correo' => $request->input('Correo')?? null,
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

    function EliminarProcesal(Request $request)
    {
        try {
            $Msj = '';
            $Msj2 = '';

            $idProcesal = $request->input('IdProcesal');

            $persona = Persona::find($idProcesal);
            $persona->estado_registro = 2;
            $persona->save();

            $Msj = 'PROCESAL ELIMINADO CORRECTAMENTE';

            return response()->json(['status' => 'success', 'Msj' => $Msj, 'Msj2' => $Msj2], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function editar_ExpedienteCivil($id)
    {
        $expediente = $this->obtenerDatosExpediente($id);
        return view('expedientes.editar-civil', compact('expediente'));
    }

    public function editar_ExpedientePenal($id)
    {
        $expediente = $this->obtenerDatosExpediente($id);
        return view('expedientes.editar-penal', compact('expediente'));
    }

    public function detalle_ExpedienteCivil($id)
    {
        $expediente = VwExpedienteDetalle::where('id', $id)->firstOrFail();

        $procesales = DB::select("CALL sp_procesales_por_expediente(?)", [$id]);

        $result = collect($procesales)->map(function ($item) {
            return [
                'IdExpediente'    => $item->id_expediente,
                'IdProcesal'      => $item->id_procesal,
                'IdPersona'       => $item->id_personas,
                'TipoPersona'     => $item->tipo_persona,
                'TipoProcesal'    => $item->tipo_procesal,
                'Condicion'       => $item->condicion,
                'Documento'       => $item->documento,
                'DatosProcesal'   => $item->datos_procesal,
            ];
        });

        return view('expedientes.detalle-civil', ['expediente' => $expediente, 'procesales' => $result,]);
    }

    public function detalle_ExpedientePenal($id)
    {
        $expediente = VwExpedienteDetalle::where('id', $id)->firstOrFail();

        $procesales = DB::select("CALL sp_procesales_por_expediente(?)", [$id]);

        $result = collect($procesales)->map(function ($item) {
            return [
                'IdExpediente'    => $item->id_expediente,
                'IdProcesal'      => $item->id_procesal,
                'IdPersona'       => $item->id_personas,
                'TipoPersona'     => $item->tipo_persona,
                'TipoProcesal'    => $item->tipo_procesal,
                'Condicion'       => $item->condicion,
                'Documento'       => $item->documento,
                'DatosProcesal'   => $item->datos_procesal,
            ];
        });

        return view('expedientes.detalle-penal', ['expediente' => $expediente, 'procesales' => $result,]);
    }

    public function ActualizarExpediente(Request $request)
    {

        $user = Auth::user();

        $params = [
            'p_idExpediente' => $request->input('IdExpediente'),
            'p_numero' => $request->input('Numero'),
            'p_carpeta' => $request->input('Carpeta'),
            'p_contrato' => $request->input('Contrato'),
            'p_fechaInicio' => $request->input('Fecha_Inicio'),
            'p_idPretension' => $request->input('Id_Pretension'),
            'p_montoPretension' => $request->input('Monto_Pretension'),
            'p_idMateria' => $request->input('Id_Materia'),
            'p_idDJudicial' => $request->input('Id_DJudicial'),
            'p_idInstancia' => $request->input('Id_Instancia'),
            'p_idFiscalia' => $request->input('Id_Fiscalia'),
            'p_idEspecialidad' => $request->input('Id_Especialidad'),
            'p_idJuzgado' => $request->input('Id_Juzgado'),
            'p_idEstado' => $request->input('Id_EstadoExpediente'),
            'p_idTipo' => $request->input('Id_TipoExpediente'),
            'p_totalSentencia' => $request->input('Monto_Sentencia'),
            'p_saldoTotal' => $request->input('Saldo_Total')
        ];

        try {

            DB::statement("SET @Msj = '', @Msj2 = ''");

            DB::select(
                'CALL sp_actualizar_expediente(
                    :p_idExpediente,
                    :p_numero,
                    :p_carpeta,
                    :p_contrato,
                    :p_fechaInicio,
                    :p_idPretension,
                    :p_montoPretension,
                    :p_idMateria,
                    :p_idDJudicial,
                    :p_idInstancia,
                    :p_idFiscalia,
                    :p_idEspecialidad,
                    :p_idJuzgado,
                    :p_idEstado,           
                    :p_idTipo,            
                    :p_totalSentencia,
                    :p_saldoTotal,
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

    public function GetArchivosEje(Request $request)
    {
        try {

            $idExpediente = $request->input('IdExpediente');

            $documentos = DocumentoLegal::where('id_expediente', $idExpediente)->where('tipo', 'EJE')->where('estado_registro', 1)->get();

            $result = $documentos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_expediente' => $item->id_expediente,
                    'nombre' => $item->nombre,
                    'tipo' => $item->tipo,
                    'formato' => $item->formato,
                    'descripcion' => $item->descripcion,
                    'url' => $item->url,
                    'fecha_registro' => $item->fecha_registro,
                    'fecha_actualizacion' => $item->fecha_actualizacion
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetArchivosEscritos(Request $request)
    {
        try {

            $idExpediente = $request->input('IdExpediente');

            $documentos = DocumentoLegal::where('id_expediente', $idExpediente)->where('tipo', 'ESCRITO')->where('estado_registro', 1)->get();

            $result = $documentos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_expediente' => $item->id_expediente,
                    'nombre' => $item->nombre,
                    'tipo' => $item->tipo,
                    'formato' => $item->formato,
                    'descripcion' => $item->descripcion,
                    'url' => $item->url,
                    'fecha_registro' => $item->fecha_registro,
                    'fecha_actualizacion' => $item->fecha_actualizacion,
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarEje(Request $request)
    {
        $request->validate([
            'idExpediente' => 'required|integer|exists:expedientes,id',
            'descripcion'  => 'nullable|string|max:255',
            'file'         => 'nullable|file|max:10240|mimes:pdf,doc,docx',
        ]);

        try {
            $usuario = Auth::user();

            if (!$request->hasFile('file')) {
                return response()->json(['status' => 'error', 'message' => 'Archivo no recibido'], Response::HTTP_NOT_FOUND);
            }

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $sanitizedName = str_replace(' ', '_', $originalName);
            $idExpediente = $request->input('idExpediente');

            // Buscar si ya existe un archivo EJE para este expediente
            $archivoExistente = DocumentoLegal::where('id_expediente', $idExpediente)
                ->where('tipo', 'EJE')
                ->where('estado_registro', 1)
                ->first();

            if ($archivoExistente) {
                // Eliminar archivo físico anterior si existe
                $oldFilePath = storage_path('app/public/eje/' . basename($archivoExistente->url));
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Guardar el nuevo archivo
                $file->storeAs('eje', $sanitizedName, 'public');

                // Actualizar datos en la base
                $archivoExistente->nombre = $originalName;
                $archivoExistente->formato = $file->getClientOriginalExtension();
                $archivoExistente->descripcion = $request->input('descripcion');
                $archivoExistente->peso = $file->getSize();
                $archivoExistente->url = '/storage/eje/' . $sanitizedName;
                $archivoExistente->usuario = $usuario->email;
                $archivoExistente->fecha_actualizacion = Carbon::now();
                $archivoExistente->save();

                return response()->json(['status' => 'success', 'Msj' => 'ARCHIVO EJE ACTUALIZADO CORRECTAMENTE'], Response::HTTP_OK);
            } else {
                // Guardar nuevo archivo
                $file->storeAs('eje', $sanitizedName, 'public');

                $archivo = new DocumentoLegal();
                $archivo->id_expediente = $idExpediente;
                $archivo->nombre = $originalName;
                $archivo->tipo = 'EJE';
                $archivo->formato = $file->getClientOriginalExtension();
                $archivo->descripcion = $request->input('descripcion');
                $archivo->peso = $file->getSize();
                $archivo->url = '/storage/eje/' . $sanitizedName;
                $archivo->usuario = $usuario->email;
                $archivo->save();

                return response()->json(['status' => 'success', 'Msj' => 'ARCHIVO EJE REGISTRADO CORRECTAMENTE'], Response::HTTP_OK);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Get_EditarEje(Request $request)
    {
        try {

            $id = $request->query('IdEje');
            $item = DocumentoLegal::where('id', $id)->where('estado_registro', 1)->firstOrFail();

            $eje = [
                'id' => $item->id,
                'id_expediente' => $item->id_expediente,
                'descripcion' => $item->descripcion,
                'nombre' => $item->nombre,
                'peso' => $item->peso,
                'url' => $item->url
            ];

            return response()->json(['status' => 'success', 'data' => $eje], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarEje(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:documentos_legales,id',
            'descripcion'  => 'required|string|max:255',
            'file'         => 'nullable|file|max:10240|mimes:pdf,doc,docx',
        ]);

        try {
            $usuario   = Auth::user();
            $id = $request->input('id');

            // Buscar el archivo existente
            $archivoExistente = DocumentoLegal::where('id', $id)
                ->where('tipo', 'EJE')
                ->where('estado_registro', 1)
                ->first();

            if (!$archivoExistente) {
                return response()->json(['status' => 'error', 'message' => 'Archivo no encontrado'], Response::HTTP_NOT_FOUND);
            }

            if ($request->hasFile('file')) {
                // Eliminar archivo físico anterior si existe
                $oldFilePath = storage_path('app/public/eje/' . basename($archivoExistente->url));
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Guardar el nuevo archivo
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $sanitizedName = str_replace(' ', '_', $originalName);
                $file->storeAs('eje', $sanitizedName, 'public');

                // Actualizar datos del archivo
                $archivoExistente->nombre = $originalName;
                $archivoExistente->formato = $file->getClientOriginalExtension();
                $archivoExistente->peso = $file->getSize();
                $archivoExistente->url = '/storage/eje/' . $sanitizedName;
            }

            // Siempre actualiza la descripción y usuario
            $archivoExistente->descripcion = $request->input('descripcion');
            $archivoExistente->usuario = $usuario->email;
            $archivoExistente->fecha_actualizacion = Carbon::now();
            $archivoExistente->save();

            return response()->json(['status' => 'success', 'Msj' => 'ARCHIVO EJE ACTUALIZADO CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EliminarEje(Request $request)
    {
        try {
            $id = $request->input('id');
            $eje = DocumentoLegal::find($id);

            $eje->estado_registro = 2;
            $eje->save();

            return response()->json(['status' => 'success', 'Msj' => 'ARCHIVO EJE ELIMINADO CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarEscrito(Request $request)
    {
        $request->validate([
            'idExpediente' => 'required|integer|exists:expedientes,id',
            'descripcion'  => 'nullable|string|max:255',
            'file'         => 'nullable|file|max:10240|mimes:pdf,doc,docx',
        ]);

        try {
            $usuario = Auth::user();

            if (!$request->hasFile('file')) {
                return response()->json(['status' => 'error', 'message' => 'Archivo no recibido'], Response::HTTP_NOT_FOUND);
            }

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $sanitizedName = str_replace(' ', '_', $originalName);
            $idExpediente = $request->input('idExpediente');

            // Guardar nuevo archivo
            $file->storeAs('escrito', $sanitizedName, 'public');

            $archivo = new DocumentoLegal();
            $archivo->id_expediente = $idExpediente;
            $archivo->nombre = $originalName;
            $archivo->tipo = 'ESCRITO';
            $archivo->formato = $file->getClientOriginalExtension();
            $archivo->descripcion = $request->input('descripcion');
            $archivo->peso = $file->getSize();
            $archivo->url = '/storage/escrito/' . $sanitizedName;
            $archivo->usuario = $usuario->email;
            $archivo->save();

            return response()->json(['status' => 'success', 'Msj' => 'ESCRITO REGISTRADO CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Get_EditarEscrito(Request $request)
    {
        try {

            $id = $request->query('IdEscrito');
            $item = DocumentoLegal::where('id', $id)->where('estado_registro', 1)->firstOrFail();

            $eje = [
                'id' => $item->id,
                'id_expediente' => $item->id_expediente,
                'descripcion' => $item->descripcion,
                'nombre' => $item->nombre,
                'peso' => $item->peso,
                'url' => $item->url
            ];

            return response()->json(['status' => 'success', 'data' => $eje], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarEscrito(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:documentos_legales,id',
            'descripcion'  => 'required|string|max:255',
            //'file'         => 'nullable|file|max:10240|mimes:pdf,doc,docx',
        ]);

        try {
            $usuario   = Auth::user();
            $id = $request->input('id');

            // Buscar el archivo existente
            $archivoExistente = DocumentoLegal::where('id', $id)
                ->where('tipo', 'ESCRITO')
                ->where('estado_registro', 1)
                ->first();

            if (!$archivoExistente) {
                return response()->json(['status' => 'error', 'message' => 'Archivo no encontrado'], Response::HTTP_NOT_FOUND);
            }

            if ($request->hasFile('file')) {
                // Eliminar archivo físico anterior si existe
                $oldFilePath = storage_path('app/public/escrito/' . basename($archivoExistente->url));
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Guardar el nuevo archivo
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $sanitizedName = str_replace(' ', '_', $originalName);
                $file->storeAs('escrito', $sanitizedName, 'public');

                // Actualizar datos del archivo
                $archivoExistente->nombre = $originalName;
                $archivoExistente->formato = $file->getClientOriginalExtension();
                $archivoExistente->peso = $file->getSize();
                $archivoExistente->url = '/storage/escrito/' . $sanitizedName;
            }

            // Siempre actualiza la descripción y usuario
            $archivoExistente->descripcion = $request->input('descripcion');
            $archivoExistente->usuario = $usuario->email;
            $archivoExistente->fecha_actualizacion = Carbon::now();
            $archivoExistente->save();

            return response()->json(['status' => 'success', 'Msj' => 'ESCRITO ACTUALIZADO CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EliminarEscrito(Request $request)
    {
        try {
            $id = $request->input('id');
            $eje = DocumentoLegal::find($id);

            $eje->estado_registro = 2;
            $eje->save();

            return response()->json(['status' => 'success', 'Msj' => 'ESCRITO ELIMINADO CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetAudiencias(Request $request)
    {
        try {

            $idExpediente = $request->input('IdExpediente');

            $audiencias = Audiencia::where('id_expediente', $idExpediente)->where('estado_Registro', 1)->get();

            $result = collect($audiencias)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_expediente' => $item->id_expediente,
                    'fecha' => FormatearFechaLarga($item->fecha),
                    'lugar' => $item->lugar,
                    'enlace' => $item->enlace,
                    'descripcion' => $item->descripcion,
                    'dias_faltantes' => $item->dias_faltantes,
                    'fecha_registro' => FormatearFechaLarga($item->fecha_registro)
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarAudiencia(Request $request)
    {
        try {
            $usuario = Auth::user();
            $audiencia = new Audiencia();

            $audiencia->id_expediente = $request->input('idExpediente');
            $audiencia->fecha = $request->input('fecha');
            $audiencia->lugar = $request->input('lugar');
            $audiencia->enlace = $request->input('enlace');
            $audiencia->descripcion = $request->input('descripcion');
            $audiencia->usuario = $usuario->email;
            $audiencia->save();

            return response()->json(['status' => 'success', 'Msj' => 'AUDIENCIA REGISTRADA CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Get_EditarAudiencia(Request $request)
    {
        try {

            $id = $request->query('Id');
            $item = Audiencia::where('id', $id)->where('estado_registro', 1)->firstOrFail();

            $data = [
                'id' => $item->id,
                'id_expediente' => $item->id_expediente,
                'fecha' => $item->fecha,
                'lugar' => $item->lugar,
                'enlace' => $item->enlace,
                'descripcion' => $item->descripcion,
                'dias_faltantes' => $item->dias_faltantes
            ];

            return response()->json(['status' => 'success', 'data' => $data], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarAudiencia(Request $request)
    {
        try {

            $id = $request->input('Id');
            $audiencia = Audiencia::where('id', $id)->where('estado_registro', 1)->firstOrFail();

            $audiencia->fecha = $request->input('fecha');
            $audiencia->lugar = $request->input('lugar');
            $audiencia->enlace = $request->input('enlace');
            $audiencia->descripcion = $request->input('descripcion');
            $audiencia->fecha_actualizacion = Carbon::now();
            $audiencia->save();

            return response()->json(['status' => 'success', 'Msj' => 'AUDIENCIA ACTUALIZADA CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EliminarAudiencia(Request $request)
    {
        try {
            $id = $request->input('id');
            $audiencia = Audiencia::find($id);
            $audiencia->estado_registro = 2;
            $audiencia->save();

            return response()->json(['status' => 'success', 'Msj' => 'AUDIENCIA ELIMINADA CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetAlertas(Request $request)
    {
        try {

            $idExpediente = $request->input('IdExpediente');

            $alertas = Alerta::where('id_expediente', $idExpediente)->where('estado_registro', 1)->get();

            $result = collect($alertas)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_expediente' => $item->id_expediente,
                    'fecha' => FormatearFechaLarga($item->fecha),
                    'descripcion' => $item->descripcion,
                    'dias_faltantes' => $item->dias_faltantes,
                    'fecha_registro' => FormatearFechaLarga($item->fecha_registro)
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function RegistrarAlerta(Request $request)
    {
        try {
            $usuario = Auth::user();
            $alerta = new Alerta();

            $alerta->id_expediente = $request->input('idExpediente');
            $alerta->fecha = $request->input('fecha');
            $alerta->descripcion = $request->input('descripcion');
            $alerta->usuario = $usuario->email;
            $alerta->save();

            return response()->json(['status' => 'success', 'Msj' => 'ALERTA REGISTRADA CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Get_EditarAlerta(Request $request)
    {
        try {

            $id = $request->query('Id');
            $item = Alerta::where('id', $id)->where('estado_registro', 1)->firstOrFail();

            $data = [
                'id' => $item->id,
                'id_expediente' => $item->id_expediente,
                'fecha' => $item->fecha,
                'descripcion' => $item->descripcion,
                'dias_faltantes' => $item->dias_faltantes
            ];

            return response()->json(['status' => 'success', 'data' => $data], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EditarAlerta(Request $request)
    {
        try {

            $id = $request->input('Id');
            $alerta = Alerta::where('id', $id)->where('estado_registro', 1)->firstOrFail();

            $alerta->fecha = $request->input('fecha');
            $alerta->descripcion = $request->input('descripcion');
            $alerta->fecha_actualizacion = Carbon::now();
            $alerta->save();

            return response()->json(['status' => 'success', 'Msj' => 'ALERTA ACTUALIZADA CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function EliminarAlerta(Request $request)
    {
        try {
            $id = $request->input('id');
            $alerta = Alerta::find($id);
            $alerta->estado_registro = 2;
            $alerta->save();

            return response()->json(['status' => 'success', 'Msj' => 'ALERTA ELIMINADA CORRECTAMENTE'], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
