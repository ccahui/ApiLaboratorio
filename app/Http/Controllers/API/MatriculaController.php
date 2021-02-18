<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Models\Matricula;
use App\Http\Resources\MatriculaCollection;
use App\Http\Resources\MatriculaResource;


class MatriculaController extends BaseController
{
    public function index(Request $request)
    {
      $matriculas = new MatriculaCollection(Matricula::paginate());
      return $matriculas;
    }

    public function store(Request $request)
    {
        
      /*  $rules =  [
            'curso_id'=>'required | exists:cursos,id',
            'cupos'=> "required",
         // TODO Validar keys 'grupo'=>'required | unique_with:laboratorios, curso_id',
            'grupo'=>['required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id,$grupo) {
                return $query->where('curso_id', $curso_id)
                ->where('grupo', $grupo);
            })],    
            'profesor_id'=>'nullable | exists:profesores,id',
            
        ];*/
        $input = $request->all();
/*
        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
*/
        $laboratorio = Matricula::create($input)->refresh();
        $data = new MatriculaResource($laboratorio);
        
        return $this->sendResponse($data, 'Matriculas retrieved successfully', 201);
    }

    public function show($id)
    {
        $matricula = Matricula::find($id);
        if($matricula == null ){
            return $this->sendError('Matricula not found');
        }
        $data = new MatriculaResource($matricula);
        return $this->sendResponse($data, 'Matricula retrieved successfully.');
    }

    //**TODO */
    public function update(Request $request, $id)
    {
        $matricula = Matricula::find($id);
        if($matricula == null ){
            return $this->sendError('Laboratorio not found');
        }
/*
        $curso_id = $matricula->curso_id; 
        $grupo = $request->grupo;
        $rules =  [
            'curso_id'=>'sometimes | required',
            'cupos'=>'sometimes | required',
            // TODO Validar keys 'grupo'=>'required | unique_with:laboratorios, curso_id,'.$laboratorio->id,
            'grupo'=>['sometimes','required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id,$grupo) {
                return $query->where('curso_id', $curso_id)
                ->where('grupo', $grupo);
            })->ignore($laboratorio->id)], 
            'profesor_id'=>'sometimes | nullable | exists:profesores,id'
        ];
        //TODO*/ 
        $input = $request->all();
        /*$validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }*/
      
        $matricula->update($input);
        $data = new MatriculaResource($matricula);

        return $this->sendResponse($data, 'Matricula updated successfully.');
    }

    public function destroy($id)
    {
        $matricula = Matricula::find($id);
        if($matricula == null ){
            return $this->sendError('Matricula not found');
        }

        $matricula->delete();
        
        $data = new MatriculaResource($matricula);
        return $this->sendResponse($data,'Matricula deleted successfully.');
    }
}
