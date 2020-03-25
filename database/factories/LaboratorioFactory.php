<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Laboratorio;
use App\Models\Curso;
use Faker\Generator as Faker;

$factory->define(Laboratorio::class, function (Faker $faker) {
    
    if(Curso::all()->count() == 0) {
        factory(Curso::class)->create();
    }
    return [
        'grupo'=>$faker->lexify('?'),
        'curso_id' => Curso::all()->random()->id, 
        'cupos'=> 20
    ];
    
});
