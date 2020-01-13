<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlumnoResource extends JsonResource
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
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'cui' => $this->cui,
            'gmail'=>$this->gmail,
            'autorizacion'=> $this->autorizacion,
            'matriculado'=>$this->matriculado
        ];
    }
}
