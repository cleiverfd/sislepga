<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procesal extends Model
{
    use HasFactory;

    protected $table = 'procesales';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'id_expediente',
        'tipo_procesal',
        'tipo_persona',
        'condicion',
        'fecha_registro',
        'fecha_actualizacion',
        'estado_registro',
        'usuario_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Relación muchos a uno
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    /**
     * Relación muchos a uno
     */
    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'id_expediente');
    }
}
