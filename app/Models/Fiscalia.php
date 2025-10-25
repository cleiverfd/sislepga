<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Fiscalia extends Model
{
    use HasApiTokens;
    use HasFactory;

   protected $table = 'fiscalias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_tipo_expediente',
        'id_distrito_judicial',
        'descripcion',
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
    public function tipoExpediente()
    {
        return $this->belongsTo(TipoExpediente::class, 'id_tipo_expediente');
    }

    /**
     * Relación muchos a uno
     */
    public function distritoJudicial()
    {
        return $this->belongsTo(DistritoJudicial::class, 'id_distrito_judicial');
    }

    /**
     * Relación uno a muchos
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'id_fiscalia');
    }
}
