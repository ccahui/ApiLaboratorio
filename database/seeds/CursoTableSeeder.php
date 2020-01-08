<?php

use Illuminate\Database\Seeder;
use App\Models\Curso;
class CursoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this -> insertarCursos(5);
    }
    
    private function insertarCursos($cantidad) {
        factory(Curso::class, $cantidad)->create();
    }
}
