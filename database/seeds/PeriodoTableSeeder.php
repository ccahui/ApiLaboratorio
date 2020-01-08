<?php

use Illuminate\Database\Seeder;
use App\Models\Periodo;

class PeriodoTableSeeder extends Seeder
{
    public function run()
    {
        $this -> insertarPeriodos();
    }
    
    private function insertarPeriodos() {
       
        $anio = $this->getCurrentYear();
        Periodo::create([
            'anio' => $anio,
            'semestre' => 'A',
        ]);
       
        Periodo::create([
            'anio' => $anio,
            'semestre' => 'B',
        ]);
    }
    
    private function getCurrentYear() {
        return date('Y');
    }
}
