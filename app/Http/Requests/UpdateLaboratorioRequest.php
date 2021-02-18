<?php

namespace App\Http\Requests;

use App\Models\Laboratorio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLaboratorioRequest extends FormRequest
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
    // URI: /laboratorios/{laboratorio}
    public function rules()
    {
        $id = $this->route('laboratorio');
        $laboratorio = Laboratorio::findOrFail($id);

        $curso_id = $this->curso_id; 
        $grupo = $this->grupo;
        
        return [
            'curso_id'=>'sometimes | required | exists:cursos,id',
            'cupos'=>'sometimes | required',
            // Clave compuesta, curso_id y grupo, Validacion
            'grupo'=>['sometimes','required', 'size:1', Rule::unique('laboratorios')->where(function ($query) use ($curso_id,$grupo) {
                return $query->where('curso_id', $curso_id)->where('grupo', $grupo);
            })->ignore($laboratorio->id)], 
            'profesor_id'=>'sometimes | nullable | exists:profesores,id'
        ];
        
    }
}
