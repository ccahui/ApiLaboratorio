<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $fillable = [
        'numero', 'descripcion','fechaInicio', 'fechaFin'
    ];

    public function alumnos(){
        return $this->hasMany(Alumno::class,'grupo_id');
    }
}
