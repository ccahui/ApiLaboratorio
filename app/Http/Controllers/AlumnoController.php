<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

use App\Models\Matricula;
use App\Models\Alumno;

use App\Http\Resources\MatriculaCollection;
use App\Http\Resources\MatriculaResource;
use Validator;
use Illuminate\Validation\Rule;

class AlumnoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laboratorios(Request $request, $id)
    {
        $alumno = Alumno::find($id); 
    
        if($alumno == null ){
            return $this->sendError('Alumno not found');
        }

        $data = $this->misLaboratorios($alumno);
        return $this->sendResponse($data,'Laboratorios matriculados de un Alumno retrieved successfully');
    }

    /**TODO pivot */
    private function misLaboratorios($alumno){
        $laboratorios = Matricula::where('alumno_id', $alumno->id)->get();
        return $laboratorios;
    }

}
