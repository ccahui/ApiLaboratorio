<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use Illuminate\Http\Request;

use App\Models\Alumno;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\AlumnoResource;

class AlumnoController extends BaseController
{

    public function index(Request $request)
    {
        $alumnos = new AlumnoCollection(Alumno::paginate());
        return $alumnos;
    }

    public function store(StoreAlumnoRequest $request)
    {
        $input = $request->all();

        $alumno = Alumno::create($input)->refresh();
        $data = new AlumnoResource($alumno);

        return $this->sendResponse($data, 'Alumno retrieved successfully', 201);
    }

    public function show($id)
    {
        $alumno = Alumno::findOrFail($id);
        
        $data = new AlumnoResource($alumno);

        return $this->sendResponse($data, 'Alumno retrieved successfully.');
    }

    public function update(UpdateAlumnoRequest $request, $id)
    {
        $alumno = Alumno::find($id);
        $input = $request->all();

        $alumno->update($input);
        $data = new AlumnoResource($alumno);

        return $this->sendResponse($data, 'Alumno updated successfully.');
    }

    public function destroy($id)
    {
        $alumno = Alumno::find($id);
        if ($alumno == null) {
            return $this->sendError('Alumno not found');
        }

        $alumno->delete();

        $data = new AlumnoResource($alumno);
        return $this->sendResponse($data, 'Alumno deleted successfully.');
    }
}
