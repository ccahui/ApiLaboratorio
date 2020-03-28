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
            'curso' => $this->cursoResource($this->curso),
            'profesor' =>$this->profesorResource($this->profesor),
        ];
    }
   
    function cursoResource($curso){
        if($curso == null)
            return null;
        else {
            return [
                'id'=>$curso->id,
                'nombre'=>$curso->nombre,
            ];
        }
    }

    function profesorResource($profesor){
        if($profesor == null)
            return null;
        else {
            return [
                'id'=>$profesor->id,
                'nombre'=>$profesor->nombre,
                'apellido'=>$profesor->apellido,
            ];
        }
    }
}
