<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlumnoCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\AlumnoResource';
    
    public function toArray($request)
    {
        return [
            'ok' => true,
            'message' => 'Alumnos retrieved successfully.',
            'data' => $this->collection,
        ];
    }
    
}
