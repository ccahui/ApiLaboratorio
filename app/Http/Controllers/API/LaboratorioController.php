<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Laboratorio;
use App\Http\Resources\LaboratorioCollection;
use App\Http\Resources\LaboratorioResource;
use Validator;
use Illuminate\Validation\Rule;

class LaboratorioController extends BaseController
{
    
    public function index(Request $request)
    {
      $laboratorios = new LaboratorioCollection(Laboratorio::paginate());
      return $laboratorios;
    }

    public function store(Request $request)
    {
           
        $curso_id = $request->curso_id; 
        $grupo = $request->grupo;

        $rules =  [
            'curso_id'=>'required | exists:cursos,id',
            'cupos'=> "required",
            //Clave compuesta curso_id y Grupo, Validacion
            'grupo'=>['required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id, $grupo) {
                return $query->where('curso_id', $curso_id)->where('grupo', $grupo);
            })],    
            'profesor_id'=>'nullable | exists:profesores,id',
        ];
        $input = $request->all();

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        $laboratorio = Laboratorio::create($input)->refresh();
        $data = new LaboratorioResource($laboratorio);
        
        return $this->sendResponse($data, 'Laboratorios retrieved successfully', 201);
    }

    public function show($id)
    {
        $laboratorio = Laboratorio::find($id);
        if($laboratorio == null ){
            return $this->sendError('Laboratorio not found');
        }
        $data = new LaboratorioResource($laboratorio);
        return $this->sendResponse($data, 'Laboratorio retrieved successfully.');
    }

    //**TODO */
    public function update(Request $request, $id)
    {
        $laboratorio = Laboratorio::find($id);
        if($laboratorio == null ){
            return $this->sendError('Laboratorio not found');
        }

        $curso_id = $laboratorio->curso_id; 
        $grupo = $request->grupo;
        $rules =  [
            'curso_id'=>'sometimes | required | exists:cursos,id',
            'cupos'=>'sometimes | required',
            // Clave compuesta, curso_id y grupo, Validacion
            'grupo'=>['sometimes','required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id,$grupo) {
                return $query->where('curso_id', $curso_id)->where('grupo', $grupo);
            })->ignore($laboratorio->id)], 
            'profesor_id'=>'sometimes | nullable | exists:profesores,id'
        ];
        //El curso de un Laboratorio NO ES MODIFICABLE luego de su creacion
        $input = $request->except('curso_id');
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
      
        $laboratorio->update($input);
        $data = new LaboratorioResource($laboratorio);

        return $this->sendResponse($data, 'Laboratorio updated successfully.');
    }

    public function destroy($id)
    {
        $laboratorio = Laboratorio::find($id);
        if($laboratorio == null ){
            return $this->sendError('Laboratorio not found');
        }

        $laboratorio->delete();
        
        $data = new LaboratorioResource($laboratorio);
        return $this->sendResponse($data,'Laboratorio deleted successfully.');
    }
}
