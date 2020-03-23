<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LaboratorioCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\LaboratorioResource';
    
    public function toArray($request)
    {
        return [
            'ok' => true,
            'message' => 'Laboratorios retrieved successfully.',
            'data' => $this->collection,
        ];
    }
    
}
