<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatriculaResource extends JsonResource
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
            'alumno' => $this->alumnoResource($this->alumno),
            'laboratorio' => new LaboratorioResource($this->laboratorio),
        ];
    }

    function alumnoResource($alumno){
        if($alumno == null)
            return null;
        else {
            return [
                'id'=>$alumno->id,
                'nombre'=>$alumno->nombre,
                'apellido'=>$alumno->apellido,
            ];
        }
    }
}
