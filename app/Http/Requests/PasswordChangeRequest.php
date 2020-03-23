<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
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
        return [
            'oldPass' => 'required|min:6',
            'newPass' => 'required|min:6',
            'newPassAgain' => 'required|min:6|same:newPass',
        ];
    }

    public function messages()
    {
        return [
          'oldPass.required' => 'Stara lozinka obavezna',
          'newPass.required' => 'Nova lozinka obavezna',
          'newPassAgain.required' => 'Ponovna lozinka obavezna',
            'min' => 'Lozinka mora biti du\a od :min karaktera',
            'same' => 'Lozinke nisu jednake'
        ];
    }
}
