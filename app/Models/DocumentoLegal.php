<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class DocumentoLegal extends Model
{
    use HasApiTokens;
    use HasFactory;

    public $timestamps = false;

    protected $table = 'documentos_legales';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id'
    ];
}
