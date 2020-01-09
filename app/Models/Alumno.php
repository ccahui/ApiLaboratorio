<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $fillable = [
        'nombre', 'apellido','gmail','cui', 'autorizacion','matriculado', 'grupo_id'
    ];
    protected $casts = [
        'autorizacion'=>'boolean',
        'matriculado'=>'boolean'
    ];

    public function grupo(){
        // Relacion de 1 --> * (Inverso)
        return $this->belongsTo(Grupo::class,'grupo_id');
    }

    public static function findByGmail($gmail){
        return static::where('gmail',$gmail)->first();
    }

    public function cursos(){
        return $this->belongsToMany(Curso::class,'matriculas')->using(Matricula::class)->withPivot('id','periodo_id','laboratorio_id');
    }
    

}

