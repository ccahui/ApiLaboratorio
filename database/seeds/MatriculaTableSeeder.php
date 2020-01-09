<?php

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Periodo;

class MatriculaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alumnos  = Alumno::all();
        foreach($alumnos as $alumno) {
            $cursos = $this->seleccionarCursos(4);
            foreach($cursos as $curso) {
               $alumno->cursos()->attach($curso->id,[
                    'periodo_id' => Periodo::all()->first()->id,
                    'laboratorio_id' => $curso->laboratorios()->get()->random()->id,
                ]);
            }
        }
    }
    private function seleccionarCursos($cantidad){
        return Curso::where('tieneLab', true)->get()->random(4);
    }
}
