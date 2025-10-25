<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoExpediente extends Model
{
    use HasFactory;

    protected $table = 'expedientes_tipos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['descripcion'];

    /**
     * Relación uno a muchos
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'id_tipo_expediente');
    }
}
