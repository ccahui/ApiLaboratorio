<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaboratorioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     
        return [
            'id' => $this->id,
            'cupos' => $this->cupos,
            'grupo' => $this->grupo,
            'curso' => new CursoResource($this->curso),
            'profesor' => new ProfesorResource($this->profesor),
        ];
    }
}
