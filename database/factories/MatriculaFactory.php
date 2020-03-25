<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Matricula;
use App\Models\Laboratorio;
use App\Models\Alumno;
use Faker\Generator as Faker;

$factory->define(Matricula::class, function (Faker $faker) {
    
    if(Alumno::all()->count() == 0) {
        factory(Alumno::class)->create();
    }
    if(Laboratorio::all()->count() == 0) {
        factory(Laboratorio::class)->create();
    }
    $laboratorio = Laboratorio::all()->random();
    return [
        'alumno_id'=>Alumno::all()->random()->id,
        'curso_id'=> $laboratorio->curso_id,
        'laboratorio_id' => $laboratorio->id, 

    ];
    
});
