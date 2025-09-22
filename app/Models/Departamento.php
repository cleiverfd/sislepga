<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Departamento extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'departamentos';     
    protected $primaryKey = 'id';     
    protected $guarded = [
        'id'
    ];
}
