<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Abogado extends Model
{
    use HasApiTokens;
    use HasFactory;

    public $timestamps = false;

    protected $table = 'abogados';
    protected $primaryKey = 'id';
    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'dni',
        'expedientes',
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
     * Relación muchos a muchos con Expediente
     */
    public function expedientes()
    {
        return $this->belongsToMany(
            Expediente::class,          
            'abogado_expediente',       
            'abogado_id',               
            'expediente_id'             
        );
    }
}   
