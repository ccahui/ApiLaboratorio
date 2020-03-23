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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $cursos = new CursoCollection(Curso::paginate());
      return $cursos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sizeCodigoCurso = 5;
        $rules =  [
            'nombre'=>'required',
            'codigo'=>"required | digits:{$sizeCodigoCurso} | unique:cursos",
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::find($id);
        if($curso == null ){
            return $this->sendError('Curso not found');
        }
        $data = new CursoResource($curso);
        return $this->sendResponse($data, 'Curso retrieved successfully.');
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
        $curso = Curso::find($id);
        if($curso == null ){
            return $this->sendError('Curso not found');
        }

        $sizeCodigoCurso = 5;
        $rules =  [
            'nombre'=>'sometimes | required',
            'codigo'=>"sometimes | required | digits:{$sizeCodigoCurso} | unique:cursos,codigo,".$curso->id,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
