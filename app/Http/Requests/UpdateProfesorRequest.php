<?php

namespace App\Http\Requests;

use App\Models\Profesor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfesorRequest extends FormRequest
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
    // URI: /profesor/{profesore}
    public function rules()
    {
        $id = $this->route('profesore');
        $profesor = Profesor::findOrFail($id);

        return [
            'nombre'=>'sometimes | required',
            'apellido'=>'sometimes | required',
            'gmail'=>'sometimes | required | email |unique:profesores,gmail,'.$profesor->id, 
        ];
    }
}
