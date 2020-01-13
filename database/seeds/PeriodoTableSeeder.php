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
       
        $year = $this->getCurrentYear();
        Periodo::create([
            'año' => $year,
            'semestre' => 'A',
        ]);
       
        Periodo::create([
            'año' => $year,
            'semestre' => 'B',
        ]);
    }
    
    private function getCurrentYear() {
        return date('Y');
    }
}
