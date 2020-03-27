<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Alumno;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\AlumnoResource;
use Validator;

class AlumnoController extends BaseController
{

    public function index(Request $request)
    {
      $alumnos = new AlumnoCollection(Alumno::paginate());
      return $alumnos;
    }

    public function store(Request $request)
    {
        $digits = 8;
        $rules =  [
            'nombre'=>'required',
            'apellido'=>'required',
            'gmail'=>'required | email | unique:alumnos',
            'cui'=>"required | digits:{$digits} | unique:alumnos",
            'grupo_id'=>'nullable | exists:grupos,id'
        ];
        $input = $request->all();

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        $alumno = Alumno::create($input)->refresh();
        $data = new AlumnoResource($alumno);
        
        return $this->sendResponse($data, 'Alumno retrieved successfully', 201);
    }

    public function show($id)
    {
        $alumno = Alumno::find($id);
        if($alumno == null ){
            return $this->sendError('Alumno not found');
        }
        $data = new AlumnoResource($alumno);
        return $this->sendResponse($data, 'Alumno retrieved successfully.');
    }

    //**TODO Validator */
    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        if($alumno == null ){
            return $this->sendError('Alumno not found');
        }

        $digits = 8;
        $rules =  [
            'nombre'=>'sometimes | required',
            'apellido'=>'sometimes | required',
            'gmail'=>'sometimes | required | email |unique:alumnos,gmail,'.$alumno->id, 
            'cui'=>"sometimes | required | digits:{$digits} | unique:alumnos,cui,".$alumno->id,
            'grupo_id'=>'sometimes | nullable | exists:grupos,id'
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
      
        $alumno->update($input);
        $data = new AlumnoResource($alumno);

        return $this->sendResponse($data, 'Alumno updated successfully.');
    }

    public function destroy($id)
    {
        $alumno = Alumno::find($id);
        if($alumno == null ){
            return $this->sendError('Alumno not found');
        }

        $alumno->delete();
        
        $data = new AlumnoResource($alumno);
        return $this->sendResponse($data,'Alumno deleted successfully.');
    }
}
