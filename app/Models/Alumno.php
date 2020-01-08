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

    public static function findByGmail($gmail){
        return static::where('gmail',$gmail)->first();
    }
}

