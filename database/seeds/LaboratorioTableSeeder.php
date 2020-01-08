<?php

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Laboratorio;
use App\Models\Profesor;

class LaboratorioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->aperturarLaboratorioYdesignarProfesor();
    }
    public function aperturarLaboratorioYdesignarProfesor(){
        $cursos = $this->cursosQueTienenLaboratorios();
        foreach($cursos as $curso){
            $curso->laboratorios()->createMany([
                $this->crearLaboratorio('A'),
                $this->crearLaboratorio('B')
             ]);
        }
    }
    
    private function crearLaboratorio($grupo){
        return ['grupo'=> $grupo, 'cupos'=> 20, 'profesor_id' => $this->randomIdProfesor()];
    }
    
    private function cursosQueTienenLaboratorios(){
        return Curso::where('tieneLab', true)->get();
    }
    

    private function randomIdProfesor(){
        return Profesor::all()->random()->id; 
    }

}
