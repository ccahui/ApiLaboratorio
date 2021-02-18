<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use Illuminate\Http\Request;

use App\Models\Curso;
use App\Http\Resources\CursoCollection;
use App\Http\Resources\CursoResource;

class CursoController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            $cursosPaginate = new CursoCollection(Curso::paginate());
            return $cursosPaginate;
        }
        $cursos = new CursoCollection(Curso::all());
        return $cursos;
    }

    public function store(StoreCursoRequest $request)
    {
        $input = $request->all();

        $curso = Curso::create($input)->refresh();
        $data = new CursoResource($curso);

        return $this->sendResponse($data, 'Curso created successfully', 201);
    }

    public function show($id)
    {
        $curso = Curso::findOrFail($id);

        $data = new CursoResource($curso);
        return $this->sendResponse($data, 'Curso retrieved successfully.');
    }

    public function update(UpdateCursoRequest $request, $id)
    {
        $curso = Curso::find($id);

        $input = $request->all();
        $curso->update($input);
        $data = new CursoResource($curso);

        return $this->sendResponse($data, 'Curso updated successfully.');
    }

    public function destroy($id)
    {
        $curso = Curso::find($id);
        if ($curso == null) {
            return $this->sendError('Curso not found');
        }

        $curso->delete();

        $data = new CursoResource($curso);
        return $this->sendResponse($data, 'Curso deleted successfully.');
    }
}
