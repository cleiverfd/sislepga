<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class RecursoSistema extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'recursos_sistema';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'slug',
        'tipo',
        'icono',
        'ruta',
        'padre_id',
        'fecha_registro',
        'fecha_actualizacion',
        'estado_registro',
        'usuario_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'usuarios_permisos', 
            'id_recurso_sistema',       
            'id_usuario'       
        );
    }
}
