<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Audiencia extends Model
{
    use HasApiTokens;
    use HasFactory;

    public $timestamps = false;

    protected $table = 'audiencias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_expediente',
        'fecha',
        'hora',
        'lugar',
        'enlace',
        'descripcion',
        'dias_faltantes',
        'fecha_registro',
        'fecha_actualizacion',
        'estado_registro',
        'usuario_registro'
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Relación uno a muchos con Expediente
     */

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'id_expediente');
    }
}
