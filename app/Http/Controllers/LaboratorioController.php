<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

use App\Models\Laboratorio;
use App\Models\Curso;
use App\Http\Resources\LaboratorioCollection;
use App\Http\Resources\LaboratorioResource;
use Validator;
use Illuminate\Validation\Rule;

class LaboratorioController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function alumnos(Request $request, $id)
    {
        $laboratorio = Laboratorio::find($id); 
    
        if($laboratorio == null ){
            return $this->sendError('Laboratorio not found');
        }

        $data = $this->alumnosMatriculados($laboratorio);
        return $this->sendResponse($data,'Alumnos matriculados en un Laboratorio retrieved successfully');
    }

    /**TODO pivot */
    private function alumnosMatriculados($laboratorio){
        $curso = $laboratorio->curso;
        $alumnosMatriculados = $curso->alumnos()->where('laboratorio_id', $laboratorio->id)->get();
        return $alumnosMatriculados;
    }

}
