<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CursoCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\CursoResource';

    public function toArray($request)
    {
        return [
            'ok' => true,
            'message' => 'Cursos retrieved successfully.',
            'data' => $this->collection,
        ];
    }
}
