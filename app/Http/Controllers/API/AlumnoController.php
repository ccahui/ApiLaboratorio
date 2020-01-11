<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Alumno;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\AlumnoResource;

class AlumnoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $alumnos = new AlumnoCollection(Alumno::paginate());
      return $alumnos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->all();
        $alumno = Alumno::create($data);
        return new AlumnoResource($alumno);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumno = Alumno::find($id);
        $data = new AlumnoResource($alumno);
        return $this->sendResponse($data, 'Alumno retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        $inputs = $request->all();
        $alumno->update($inputs);
        
        $data = new AlumnoResource($alumno);

        return $this->sendResponse($data, 'Alumno updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alumno = Alumno::find($id);
        $alumno->delete();

        $data = new AlumnoResource($alumno);
        return $this->sendResponse($data,'Alumno deleted successfully.');
    }
}
