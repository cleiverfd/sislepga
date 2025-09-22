<?php

use Carbon\Carbon;

if (!function_exists('FormatearFechaLarga')) {
    function FormatearFechaLarga(string $fechaCadena): string
    {
        $fecha = Carbon::parse($fechaCadena)->locale('es');

        $dia = $fecha->format('d');
        $mes = ucfirst(substr($fecha->locale('es')->isoFormat('MMM'), 0, 3));
        $anio = $fecha->format('Y');
        $hora = $fecha->format('H:i:s');

        return "$dia $mes $anio $hora";
    }
}

if (!function_exists('formatearFechaCorta')) {
    function formatearFechaCorta($fechaCadena): string
    {
        $fecha = Carbon::parse($fechaCadena)->locale('es');
        $dia = $fecha->format('d');
        $mes = ucfirst(substr($fecha->isoFormat('MMM'), 0, 3));
        $anio = $fecha->format('Y');
        return "$dia $mes $anio";
    }
}
