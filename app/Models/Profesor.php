<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';
    protected $fillable = [
        'nombre', 'apellido','gmail','descripcion'
    ];

    public static function findByGmail($gmail){
        return static::where('gmail',$gmail)->first();
    }
}
