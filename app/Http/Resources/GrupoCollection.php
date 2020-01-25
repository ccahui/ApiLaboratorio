<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GrupoCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\GrupoResource';

    public function toArray($request)
    {
        return [
            'ok' => true,
            'message' => 'Grupos retrieved successfully.',
            'data'=>$this->collection
        ];
    }
}
