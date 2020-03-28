<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

use App\Models\Matricula;
use App\Models\Alumno;

use App\Http\Resources\MatriculaCollection;
use App\Http\Resources\MatriculaResource;
use App\Http\Resources\LaboratorioResource;
use App\Http\Resources\AlumnoResource;
use App\Http\Resources\CursoCollection;
use App\Http\Resources\CursoResource;
use Validator;
use Illuminate\Validation\Rule;

class AlumnoController extends BaseController
{
    
    public function laboratorios(Request $request, $id)
    {
        $alumno = Alumno::find($id); 
        if($alumno == null ){
            return $this->sendError('Alumno not found');
        }

        $alumnoResource = new AlumnoResource($alumno);
        $laboratoriosResource = LaboratorioResource::collection($alumno->laboratorios);
        $data = [
            'alumno' => $alumnoResource,
            'laboratorios' => $laboratoriosResource
        ];
        return $this->sendResponse($data,'Laboratorios matriculados de un Alumno retrieved successfully');
    }

    /**TODO */
    private function misLaboratorios($alumno){
        $laboratorios = Matricula::where('alumno_id', $alumno->id)->get();
        return $laboratorios;
    }

}
