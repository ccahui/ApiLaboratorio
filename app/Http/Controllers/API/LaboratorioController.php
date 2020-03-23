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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $laboratorios = new LaboratorioCollection(Laboratorio::paginate());
      return $laboratorios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $sizeCui = 8;   
        $curso_id = $request->curso_id; 
        $grupo = $request->grupo;

        $rules =  [
            'curso_id'=>'required | exists:cursos,id',
            'cupos'=> "required",
         // TODO Validar keys 'grupo'=>'required | unique_with:laboratorios, curso_id',
            'grupo'=>['required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id,$grupo) {
                return $query->where('curso_id', $curso_id)
                ->where('grupo', $grupo);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laboratorio = Laboratorio::find($id);
        if($laboratorio == null ){
            return $this->sendError('Laboratorio not found');
        }
        $data = new LaboratorioResource($laboratorio);
        return $this->sendResponse($data, 'Laboratorio retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'curso_id'=>'sometimes | required',
            'cupos'=>'sometimes | required',
            // TODO Validar keys 'grupo'=>'required | unique_with:laboratorios, curso_id,'.$laboratorio->id,
            'grupo'=>['sometimes','required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id,$grupo) {
                return $query->where('curso_id', $curso_id)
                ->where('grupo', $grupo);
            })->ignore($laboratorio->id)], 
            'profesor_id'=>'sometimes | nullable | exists:profesores,id'
        ];
        //TODO 
        $input = $request->except('curso_id');
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
      
        $laboratorio->update($input);
        $data = new LaboratorioResource($laboratorio);

        return $this->sendResponse($data, 'Laboratorio updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
