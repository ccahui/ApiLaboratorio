<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = [
        'nombre', 'codigo','tieneLab'
    ];

    public function laboratorios(){
        return $this->hasMany(Laboratorio::class,'curso_id');
    }

}

