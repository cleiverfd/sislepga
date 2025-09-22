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
    protected $guarded = [
        'id'
    ];
}
