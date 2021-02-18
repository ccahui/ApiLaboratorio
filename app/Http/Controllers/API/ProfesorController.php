<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreProfesorRequest;
use App\Http\Requests\UpdateProfesorRequest;
use Illuminate\Http\Request;

use App\Models\Profesor;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\ProfesorResource;

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
    public function store(StoreProfesorRequest $request)
    {
        $input = $request->all();

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
        $profesor = Profesor::findOrFail($id);

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
    public function update(UpdateProfesorRequest $request, $id)
    {
        $profesor = Profesor::find($id);
        
        $input = $request->all();

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
        if ($profesor == null) {
            return $this->sendError('Profesor not found');
        }

        $profesor->delete();

        $data = new ProfesorResource($profesor);
        return $this->sendResponse($data, 'Profesor deleted successfully.');
    }
}
