<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = "laboratorios";
    protected $fillable = [
        'cupos', 'grupo', 'curso_id','profesor_id'
    ];

    public function curso(){
        // Relacion de 1 --> * (Inverso)
        return $this->belongsTo(Curso::class,'curso_id');
    }

    public function profesor(){
        // Relacion de 1 --> * (Inverso)
        return $this->belongsTo(Profesor::class,'profesor_id');
    }

    public function alumnos(){
        return $this->belongsToMany(Alumno::class,'matriculas')->using(Matricula::class)->withPivot('id');
    }
    
}