<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Curso;
use App\Http\Resources\CursoCollection;
use App\Http\Resources\CursoResource;
use Validator;

class CursoController extends BaseController
{
    public function index(Request $request)
    {
        if($request->has('page')){
            $cursosPaginate = new CursoCollection(Curso::paginate()); 
            return $cursosPaginate;
        }
        $cursos = new CursoCollection(Curso::all());
        return $cursos;
    }

    public function store(Request $request)
    {
        $digits = 5;
        $rules =  [
            'nombre'=>'required',
            'codigo'=>"required | digits:{$digits} | unique:cursos",
        ];
        $input = $request->all();

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        $curso = Curso::create($input)->refresh();
        $data = new CursoResource($curso);
        
        return $this->sendResponse($data, 'Curso created successfully', 201);
    }

    public function show($id)
    {
        $curso = Curso::find($id);
        if($curso == null ){
            return $this->sendError('Curso not found');
        }
        $data = new CursoResource($curso);
        return $this->sendResponse($data, 'Curso retrieved successfully.');
    }

    //**TODO */
    public function update(Request $request, $id)
    {
        $curso = Curso::find($id);
        if($curso == null ){
            return $this->sendError('Curso not found');
        }

        $digits = 5;
        $rules =  [
            'nombre'=>'sometimes | required',
            'codigo'=>"sometimes | required | digits:{$digits} | unique:cursos,codigo,".$curso->id,
        ];
        
        $input = $request->all();
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
      
        $curso->update($input);
        $data = new CursoResource($curso);

        return $this->sendResponse($data, 'Curso updated successfully.');
    }

    public function destroy($id)
    {
        $curso = Curso::find($id);
        if($curso == null ){
            return $this->sendError('Curso not found');
        }

        $curso->delete();
        
        $data = new CursoResource($curso);
        return $this->sendResponse($data,'Curso deleted successfully.');
    }
}
