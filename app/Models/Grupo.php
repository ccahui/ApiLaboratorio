<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $fillable = [
        'numero', 'descripcion','fechaInicio', 'fechaFin'
    ];
}
