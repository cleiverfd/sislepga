<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Distrito extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'distritos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_departamento',
        'id_provincia',
        'descripcion',
    ];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'id_provincia');
    }
}
