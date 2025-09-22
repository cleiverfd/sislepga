<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class DistritoJudicial extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'distritos_judiciales';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];

    public function juzgados()
    {
        return $this->hasMany(Juzgado::class, 'id_distrito_judicial');
    }
}
