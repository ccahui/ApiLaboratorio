<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Curso;
use Faker\Generator as Faker;

$factory->define(Curso::class, function (Faker $faker) {

    return [
        'nombre' => $faker->lexify('????? ?????'),
        'codigo'=>$faker->numberBetween($inicio = 13001, $fin=17100),
        'tieneLab' => rand(0,1) == 1,
    ];
});
