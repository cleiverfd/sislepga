<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Abogado extends Model
{
    use HasApiTokens;
    use HasFactory;

    public $timestamps = false;

    protected $table = 'abogados';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];
}
