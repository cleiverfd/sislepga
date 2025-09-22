<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function GetExpedientesPorMes()
    {
        try {

            $response = DB::select("CALL sp_listar_expedientesPorMes()");

            $result = collect($response)->map(function ($item) {
                return [
                    'anio'                          => $item->anio,
                    'mes'                           => $item->mes,
                    'id_estado_expediente'          => $item->id_estado_expediente,
                    'estado_expediente'             => $item->estado_expediente,
                    'total'                         => $item->total
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetUltimosExpedientes()
    {
        try {

            $response = DB::table('vw_ultimos_expedientes')->get();

            $result = $response->map(function ($item) {
                return [
                    'idExpediente'      => $item->id_expediente,
                    'numero'            => $item->numero,
                    'fechaInicio'       => formatearFechaCorta($item->fecha_inicio),
                    'idPretension'      => $item->id_pretension,
                    'pretension'        => $item->pretension,
                    'idEstadoExpediente' => $item->id_estado_expediente,
                    'estadoExpediente'  => $item->estado_expediente,
                    'procesales'          => $item->procesales,
                    'fechaRegistro'     => FormatearFechaLarga($item->fecha_registro),
                ];
            });

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function GetTotalProcesales()
    {
        try {

            $result = DB::table('procesales')->where('estado_registro', 1)->distinct('id_persona')->count();

            return response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
