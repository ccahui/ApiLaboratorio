<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlumnoCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Member';
    
    public function toArray($request)
    {
        return $this->collection;
    }
}
