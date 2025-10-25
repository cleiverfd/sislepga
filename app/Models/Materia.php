<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Materia extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'materias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_tipo_expediente',
        'descripcion',
        'fecha_registro',
        'estado_registro',
        'usuario_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime'
    ];

    /**
     * Relación muchos a uno
     */
    public function tipoExpediente()
    {
        return $this->belongsTo(TipoExpediente::class, 'id_tipo_expediente');
    }

    /**
     * Relación uno a muchos
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'id_materia');
    }
}
