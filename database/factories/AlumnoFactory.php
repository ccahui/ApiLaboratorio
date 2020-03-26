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
    /**TODO doWhile generar un CUI UNIQUE*/
    $cui = $faker->numberBetween($inicio = 20150000, $fin=20200000);
    while(Alumno::where('cui',$cui)->count()){
        $cui = $faker->numberBetween($inicio = 20150000, $fin=20200000);
    }
    
    return [
        'nombre'=> $faker->name,
        'cui'=>$cui,
        'apellido'=>$faker->lexify('????? ????'),
        'gmail' => $faker->unique()->safeEmail,
        'grupo_id' => Grupo::all()->random()->id,
        'autorizacion'=>true
    ]; 
});
