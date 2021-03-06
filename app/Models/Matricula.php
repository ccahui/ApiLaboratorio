<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Matricula extends Pivot
{
    public $incrementing = true;
    protected $table = "matriculas";

    public function curso() {
        // Relacion de * --> *
        return $this->belongsTo(Curso::class,'curso_id');
      }
    
    public function alumno() {
          // Relacion de * --> *
          return $this->belongsTo(Alumno::class,'alumno_id');
    }
    /*TODO */
    public function laboratorio(){
      // Relacion de 1 --> * (Inverso)
      return $this->belongsTo(Laboratorio::class,'laboratorio_id');
  }
}