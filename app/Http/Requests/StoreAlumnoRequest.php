<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class StoreAlumnoRequest extends FormRequest
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
    {   $digits = 8;
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'gmail' => 'required | email | unique:alumnos',
            'cui' => "required | digits:{$digits} | unique:alumnos",
            'grupo_id' => 'nullable | exists:grupos,id'
        ];
    }
    
}
