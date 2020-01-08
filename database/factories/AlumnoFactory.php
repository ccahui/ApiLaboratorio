<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Alumno;
use Faker\Generator as Faker;
use App\Models\Grupo;
$factory->define(Alumno::class, function (Faker $faker) {
    if(Grupo::all()->count() == 0) {
        factory(Grupo::class)->create();
    }
    return [
        'nombre'=> $faker->name,
        'cui'=>$faker->numberBetween($inicio = 2015000, $fin=2020000),
        'apellido'=>$faker->lexify('????? ????'),
        'gmail' => $faker->unique()->safeEmail,
        'grupo_id' => Grupo::all()->random()->id,
        'autorizacion'=>true
    ]; 
});
