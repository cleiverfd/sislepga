<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

class ReporteController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function Reportes()
    {
        try {
            return view('reportes.reporte');
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
