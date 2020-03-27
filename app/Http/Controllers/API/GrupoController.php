<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Grupo;
use App\Http\Resources\GrupoCollection;
use App\Http\Resources\GrupoResource;
use Validator;

class GrupoController extends BaseController
{
    
    public function index()
    {
        $grupos = new GrupoCollection(Grupo::all());
        return $grupos;
    }
    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $grupo = Grupo::find($id);
        if($grupo == null ){
            return $this->sendError('Grupo not found');
        }
        $data = new GrupoResource($grupo);
        return $this->sendResponse($data, 'Grupo retrieved successfully.');
    }

   
    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        //
    }
}
