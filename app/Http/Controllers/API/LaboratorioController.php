<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreLaboratorioRequest;
use App\Http\Requests\UpdateLaboratorioRequest;

use App\Models\Laboratorio;
use App\Http\Resources\LaboratorioCollection;
use App\Http\Resources\LaboratorioResource;

class LaboratorioController extends BaseController
{

    public function index()
    {
        $laboratorios = new LaboratorioCollection(Laboratorio::paginate());
        return $laboratorios;
    }

    public function store(StoreLaboratorioRequest $request)
    {
        $input = $request->all();

        $laboratorio = Laboratorio::create($input)->refresh();
        $data = new LaboratorioResource($laboratorio);

        return $this->sendResponse($data, 'Laboratorios retrieved successfully', 201);
    }

    public function show($id)
    {
        $laboratorio = Laboratorio::findOrFail($id);

        $data = new LaboratorioResource($laboratorio);
        return $this->sendResponse($data, 'Laboratorio retrieved successfully.');
    }

    public function update(UpdateLaboratorioRequest $request, $id)
    {
        $laboratorio = Laboratorio::find($id);

        //El curso de un Laboratorio NO ES MODIFICABLE luego de su creacion
        $input = $request->except('curso_id');

        $laboratorio->update($input);
        $data = new LaboratorioResource($laboratorio);

        return $this->sendResponse($data, 'Laboratorio updated successfully.');
    }

    public function destroy($id)
    {
        $laboratorio = Laboratorio::find($id);
        if ($laboratorio == null) {
            return $this->sendError('Laboratorio not found');
        }

        $laboratorio->delete();

        $data = new LaboratorioResource($laboratorio);
        return $this->sendResponse($data, 'Laboratorio deleted successfully.');
    }
}
