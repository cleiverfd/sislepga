<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class VwExpedienteDetalle extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'vw_expediente_detalle'; // nombre exacto de la vista en MySQL

    public $incrementing = false; // si no tiene clave primaria autoincremental
    public $timestamps = false;   // si la vista no tiene campos created_at / updated_at

    protected $guarded = [];
}
