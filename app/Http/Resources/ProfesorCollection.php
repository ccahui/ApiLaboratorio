<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfesorCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\ProfesorResource';

    public function toArray($request)
    {
        return [
            'ok' => true,
            'message' => 'Profesores retrieved successfully.',
            'data' => $this->collection,
        ];
    }
}
