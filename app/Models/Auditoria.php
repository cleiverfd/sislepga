<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditorias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tabla',
        'id_registro',
        'id_usuario',
        'accion',
        'datos_anteriores',
        'datos_nuevos'
    ];

    /**
     * Convierte automáticamente los campos JSON a arreglo o colección.
     */
    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'fecha_registro' => 'datetime',
    ];
}
