<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Instancia extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'instancias';     
    protected $primaryKey = 'id';     
    protected $guarded = [
        'id'
    ];
}
