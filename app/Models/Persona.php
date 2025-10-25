<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Persona extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'ruc',
        'razon_social',
        'telefono',
        'correo',
        'tipo_procesal',
        'tipo_persona',
        'condicion',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'direccion',
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
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /**
     * Relación muchos a uno
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    /**
     * Relación muchos a uno
     */
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    /**
     * Relación uno a muchos
     */
    public function comunicaciones()
    {
        return $this->hasMany(Comunicacion::class, 'id_persona');
    }
}
