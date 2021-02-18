<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaboratorioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $curso_id = $this->curso_id; 
        $grupo = $this->grupo;
        return [
            'curso_id'=>'required | exists:cursos,id',
            'cupos'=> "required",
            //Clave compuesta curso_id y Grupo, Validacion
            'grupo'=>['required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id, $grupo) {
                return $query->where('curso_id', $curso_id)->where('grupo', $grupo);
            })],    
            'profesor_id'=>'nullable | exists:profesores,id',
        ];
    }
}
