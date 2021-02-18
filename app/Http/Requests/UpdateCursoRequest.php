<?php

namespace App\Http\Requests;

use App\Models\Curso;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
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
        $id = $this->route('curso');
        $curso = Curso::findOrFail($id);

        $digits = 5;
        return [
            'nombre' => 'sometimes | required',
            'codigo' => "sometimes | required | digits:{$digits} | unique:cursos,codigo," . $curso->id,
        ];
    }
}
