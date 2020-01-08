<?php

use Illuminate\Database\Seeder;
use App\Models\Profesor;
class ProfesorTableSeeder extends Seeder
{

    public function run()
    {
        $this -> insertarProfesores(5);
    }
    
    private function insertarProfesores($cantidad) {
        factory(Profesor::class, $cantidad)->create();
    }
}
