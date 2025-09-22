<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Expediente extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'expedientes';     
    protected $primaryKey = 'id';     
    protected $guarded = [
        'id'
    ];
}
