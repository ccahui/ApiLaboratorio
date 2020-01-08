<?php

use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GrupoTableSeeder extends Seeder
{
    public function run()
    {
        $this -> insertarGrupos();
    }
    
    private function insertarGrupos() {
        $dateGrupo1 = now();
        $dateGrupo2 = $this->siguienteSemana($dateGrupo1);
        $dateGrupo3 = $this->siguienteSemana($dateGrupo2);
        
        Grupo::create([
            'numero' => 1,
            'descripcion' => 'Grupo 1',
            'fechaInicio'=> $dateGrupo1,
            'fechaFin'=> $dateGrupo2,
            ]);
       
        Grupo::create([
            'numero' => 2,
            'descripcion' => 'Grupo 2',
            'fechaInicio'=> $dateGrupo2,
            'fechaFin'=> $dateGrupo3,
            ]);

        Grupo::create([
            'numero' => 3,
            'descripcion' => 'Grupo 3',
            'fechaInicio'=> $dateGrupo3,
            'fechaFin'=> $this->siguienteSemana($dateGrupo3),
            ]);
       
    }

    
    private function siguienteSemana($date){
        return $date->add(new DateInterval('P7D'));
    }
    
}
