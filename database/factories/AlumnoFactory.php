<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Alumno;
use Faker\Generator as Faker;
use App\Models\Grupo;
$factory->define(Alumno::class, function (Faker $faker) {
    if(Grupo::all()->count() == 0) {
        Grupo::create([
            'numero' => 1,
            'descripcion' => 'Grupo 1',
            'fechaInicio'=> now(),
            'fechaFin'=> now(),
            ]);
    }
    return [
        'nombre'=> $faker->name,
        'cui'=>$faker->numberBetween($inicio = 20150000, $fin=20200000),
        'apellido'=>$faker->lexify('????? ????'),
        'gmail' => $faker->unique()->safeEmail,
        'grupo_id' => Grupo::all()->random()->id,
        'autorizacion'=>true
    ]; 
});
