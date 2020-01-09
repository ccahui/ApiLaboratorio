<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';
    protected $fillable = [
        'nombre', 'apellido','gmail','descripcion'
    ];

    public function laboratorios(){
        return $this->hasMany(Laboratorio::class,'profesor_id');
    }

    public function getCursos(){
        $idsCursos = $this->laboratorios->pluck('curso_id')->unique();
        return Curso::whereIn('id', $idsCursos)->get();
    }
    
    public static function findByGmail($gmail){
        return static::where('gmail',$gmail)->first();
    }

}
