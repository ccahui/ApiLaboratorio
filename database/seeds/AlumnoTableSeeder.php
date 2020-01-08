<?php

use Illuminate\Database\Seeder;
use App\Models\Alumno;
class AlumnoTableSeeder extends Seeder
{
    public function run()
    {
        $this -> insertarAlumnos(20);
    }
    
    private function insertarAlumnos($cantidad) {
        factory(Alumno::class, $cantidad)->create();
    }
}
