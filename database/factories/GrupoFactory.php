<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Grupo;
use Faker\Generator as Faker;

$factory->define(Grupo::class, function (Faker $faker) {

    $fecha = now();

    return [
        'numero' => $faker->numberBetween($inicio = 1, $fin = 1000),
        'descripcion'=>$faker->text,
        'fechaInicio' => $fecha,
        'fechaFin' => $fecha
    ];
});
