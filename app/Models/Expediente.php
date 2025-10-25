<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Expediente extends Model
{
    use HasApiTokens;
    use HasFactory;

     protected $table = 'expedientes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'numero',
        'carpeta_fiscal',
        'sentencia',
        'contrato_referencia',
        'fecha_inicio',
        'id_pretension',
        'id_materia',
        'id_distrito_judicial',
        'id_instancia',
        'id_especialidad',
        'id_juzgado',
        'id_fiscalia',
        'id_abogado',
        'id_tipo_expediente',
        'monto_pretension',
        'estado_expediente',
        'monto_sentencia_1',
        'monto_sentencia_2',
        'monto_intereses',
        'monto_honorario_fijo',
        'monto_honorario_sentencia_1',
        'monto_honorario_sentencia_2',
        'monto_honorario_sentencia_interes',
        'monto_costos',
        'fecha_registro',
        'fecha_actualizacion',
        'estado_registro',
        'usuario_registro',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
        'monto_pretension' => 'decimal:2',
        'monto_sentencia_1' => 'decimal:2',
        'monto_sentencia_2' => 'decimal:2',
        'monto_intereses' => 'decimal:2',
        'monto_honorario_fijo' => 'decimal:2',
        'monto_honorario_sentencia_1' => 'decimal:2',
        'monto_honorario_sentencia_2' => 'decimal:2',
        'monto_honorario_sentencia_interes' => 'decimal:2',
        'monto_costos' => 'decimal:2',
    ];

    /**
     * Relación muchos a uno
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }

    /**
     * Relación muchos a uno
     */
    public function pretension()
    {
        return $this->belongsTo(Pretension::class, 'id_pretension');
    }

    /**
     * Relación muchos a uno
     */
    public function distritoJudicial()
    {
        return $this->belongsTo(DistritoJudicial::class, 'id_distrito_judicial');
    }

    /**
     * Relación muchos a uno
     */
    public function instancia()
    {
        return $this->belongsTo(Instancia::class, 'id_instancia');
    }

    /**
     * Relación muchos a uno
     */
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    /**
     * Relación muchos a uno
     */
    public function juzgado()
    {
        return $this->belongsTo(Juzgado::class, 'id_juzgado');
    }

    /**
     * Relación muchos a uno
     */
    public function fiscalia()
    {
        return $this->belongsTo(Fiscalia::class, 'id_fiscalia');
    }

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
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_expediente');
    }

    /**
     * Relación uno a muchos
     */
    public function comunicaciones()
    {
        return $this->hasMany(Comunicacion::class, 'id_expediente');
    }

    /**
     * Relación uno a muchos
     */
    public function alertas()
    {
        return $this->hasMany(Alerta::class, 'id_expediente');
    }

    /**
     * Relación muchos a muchos con Abogado
     */
    public function abogados()
    {
        return $this->belongsToMany(
            Abogado::class,
            'abogado_expediente',
            'expediente_id',
            'abogado_id'
        );
    }
}
