<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profesor;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\ProfesorResource;
use Validator;

class ProfesorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $profesores = new ProfesorCollection(Profesor::paginate());
      return $profesores;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'nombre'=>'required',
            'apellido'=>'required',
            'gmail'=>'required | email | unique:profesores'
        ];
        $input = $request->all();

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }

        $profesor = Profesor::create($input)->refresh();
        $data = new ProfesorResource($profesor);
        
        return $this->sendResponse($data, 'Profesor created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profesor = Profesor::find($id);
        if($profesor == null ){
            return $this->sendError('Profesor not found');
        }
        $data = new ProfesorResource($profesor);
        return $this->sendResponse($data, 'Profesor retrieved successfully.');
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
        $profesor = Profesor::find($id);
        if($profesor == null ){
            return $this->sendError('Profesor not found');
        }

        $rules =  [
            'nombre'=>'sometimes | required',
            'apellido'=>'sometimes | required',
            'gmail'=>'sometimes | required | email |unique:profesores,gmail,'.$profesor->id, 
        ];
        
        $input = $request->all();
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);       
        }
      
        $profesor->update($input);
        $data = new ProfesorResource($profesor);

        return $this->sendResponse($data, 'Profesor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profesor = Profesor::find($id);
        if($profesor == null ){
            return $this->sendError('Profesor not found');
        }

        $profesor->delete();
        
        $data = new ProfesorResource($profesor);
        return $this->sendResponse($data,'Profesor deleted successfully.');
    }
}
