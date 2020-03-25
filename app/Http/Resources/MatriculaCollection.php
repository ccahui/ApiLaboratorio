<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MatriculaCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\MatriculaResource';
    
    public function toArray($request)
    {
        return [
            'ok' => true,
            'message' => 'Matriculas retrieved successfully.',
            'data' => $this->collection,
        ];
    }
    
}
