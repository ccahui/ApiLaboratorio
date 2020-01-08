<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Matricula extends Pivot
{
    public $incrementing = true;
    protected $table = "matriculas";

    public function curso() {
        return $this->belongsTo(Curso::class,'curso_id');
      }
    
      public function alumno() {
          return $this->belongsTo(Alumno::class,'alumno_id');
      }
}