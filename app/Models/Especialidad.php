<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Especialidad extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'especialidades';     
    protected $primaryKey = 'id';     
    protected $guarded = [
        'id'
    ];
}
