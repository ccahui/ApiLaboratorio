<?php

namespace App\Http\Requests;

use App\Models\Alumno;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateAlumnoRequest extends FormRequest
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

    // URI: /alumnos/{alumno}
    public function rules()
    {
       
        $id = $this->route('alumno');
        
        $alumno = Alumno::findOrFail($id);

        $digits = 8;
        return  [
            'nombre'=>'sometimes | required',
            'apellido'=>'sometimes | required',
            'gmail'=>'sometimes | required | email |unique:alumnos,gmail,'.$alumno->id, 
            'cui'=>"sometimes | required | digits:{$digits} | unique:alumnos,cui,".$alumno->id,
            'grupo_id'=>'sometimes | nullable | exists:grupos,id'
        ];
    }
}
