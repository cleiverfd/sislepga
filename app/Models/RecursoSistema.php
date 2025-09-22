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
    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'usuarios_permisos', // tabla pivote
            'id_recurso_sistema',        // FK a recursos
            'id_usuario'         // FK a usuarios
        );
    }
}
