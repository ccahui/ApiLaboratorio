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

class CursoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function laboratorios(Request $request, $id)
    {
        $curso = Curso::find($id); 
    
        if($curso == null ){
            return $this->sendError('Curso not found');
        }

        $data = $curso->laboratorios;
        return $this->sendResponse($data,'Laboratorios de un Curso retrieved successfully');
    }

   

}
