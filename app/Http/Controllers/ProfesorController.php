<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

use App\Models\Laboratorio;
use App\Models\Profesor;

use App\Http\Resources\LaboratorioCollection;
use App\Http\Resources\LaboratorioResource;
use App\Http\Resources\ProfesorResource;
use Validator;
use Illuminate\Validation\Rule;

class ProfesorController extends BaseController
{
    public function laboratorios(Request $request, $id)
    {
        $profesor = Profesor::find($id); 
    
        if($profesor == null ){
            return $this->sendError('Profesor not found');
        }
        $profesorResource = new ProfesorResource($profesor);
        $laboratoriosResource = LaboratorioResource::collection($profesor->laboratorios);
        $data = [
            'profesor' => $profesorResource,
            'laboratorios' => $laboratoriosResource
        ];
        return $this->sendResponse($data,'Laboratorios de un Profesor retrieved successfully');
    }

    /**TODO pivot */
    private function misLaboratorios($profesor){
        $laboratorios = Laboratorio::where('profesor_id', $profesor->id)->get();
        return $laboratorios;
    }

}
