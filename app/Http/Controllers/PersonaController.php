<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class PersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function listarPersonas()
    {
        try {
            return view('personas.persona-listar');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function GetPersonas()
    {
        try {

            $response = DB::select("CALL sp_listar_procesales()");

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
}
