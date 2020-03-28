<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

use App\Models\Laboratorio;
use App\Models\Curso;

use App\Http\Resources\LaboratorioCollection;
use App\Http\Resources\LaboratorioResource;
use App\Http\Resources\CursoResource;
use Validator;
use Illuminate\Validation\Rule;

class CursoController extends BaseController
{
  
    public function laboratorios(Request $request, $id)
    {
        $curso = Curso::find($id); 
    
        if($curso == null ){
            return $this->sendError('Curso not found');
        }

        $cursoResource = new CursoResource($curso);
        $laboratoriosResource = LaboratorioResource::collection($curso->laboratorios);
        $data = [
            'curso' => $cursoResource,
            'laboratorios' => $laboratoriosResource
        ];
        return $this->sendResponse($data,'Laboratorios de un Curso retrieved successfully');
    }

   

}
