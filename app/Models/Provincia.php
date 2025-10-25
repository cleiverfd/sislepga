<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Provincia extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'provincias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_departamento',
        'descripcion',
    ];

    /**
     * Relación: una provincia pertenece a un departamento.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
}
