<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

/**
 * Controlador del Dashboard
 * 
 * Maneja la visualización del panel principal y proporciona
 * datos estadísticos sobre expedientes y procesales
 */
class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del dashboard
     */
    public function index(): View
    {
        return view('dashboard.index');
    }

    /**
     * Obtiene estadísticas de expedientes agrupados por mes y estado
     * 
     * @return JsonResponse
     */
    public function getExpedientesPorMes(): JsonResponse
    {
        try {
            $expedientes = DB::select("CALL sp_listar_expedientesPorMes()");

            $resultado = collect($expedientes)->map(function ($item) {
                return [
                    'anio' => $item->anio,
                    'mes' => $item->mes,
                    'id_estado_expediente' => $item->id_estado_expediente,
                    'estado_expediente' => $item->estado_expediente,
                    'total' => (int) $item->total
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $resultado
            ]);
        } catch (Throwable $e) {
            Log::error('Error al obtener expedientes por mes', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los datos de expedientes.'
            ], 500);
        }
    }

    /**
     * Obtiene los últimos expedientes registrados
     * 
     * @return JsonResponse
     */
    public function getUltimosExpedientes(Request $request): JsonResponse
    {
        try {
            // Obtener el límite desde query params o usar 20 por defecto
            $limite = $request->input('limite', 20);
            
            $expedientes = DB::select("CALL sp_listar_ultimos_expedientes(?)", [$limite]);

            $resultado = collect($expedientes)->map(function ($item) {
                return [
                    'idExpediente' => $item->id_expediente,
                    'numero' => $item->numero,
                    'fechaInicio' => formatearFechaCorta($item->fecha_inicio),
                    'idPretension' => $item->id_pretension,
                    'pretension' => $item->pretension,
                    'idEstadoExpediente' => $item->id_estado_expediente,
                    'estadoExpediente' => $item->estado_expediente,
                    'procesales' => (int) $item->procesales,
                    'fechaRegistro' => formatearFechaLarga($item->fecha_registro),
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $resultado
            ]);
        } catch (Throwable $e) {
            Log::error('Error al obtener últimos expedientes', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los últimos expedientes.'
            ], 500);
        }
    }

    /**
     * Obtiene el total de procesales únicos activos
     * 
     * @return JsonResponse
     */
    public function getTotalProcesales(): JsonResponse
    {
        try {
            $total = DB::table('procesales')
                ->where('estado_registro', 1)
                ->distinct()
                ->count('id_persona');

            return response()->json([
                'status' => 'success',
                'data' => $total
            ]);
        } catch (Throwable $e) {
            Log::error('Error al obtener total de procesales', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener el total de procesales.'
            ], 500);
        }
    }
}
