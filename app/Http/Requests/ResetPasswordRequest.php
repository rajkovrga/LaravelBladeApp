<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'newPass' => 'required|min:6',
            'newPassAgain' => 'required|min:6|same:newPass',
            'token' => 'required|jwt'
        ];
    }

    public function messages()
    {
        return [
            'newPass.required' => 'Nova lozinka obavezna',
            'newPassAgain.required' => 'Ponovna lozinka obavezna',
            'min' => 'Lozinka mora biti duža od :min karaktera',
            'same' => 'Lozinke nisu jednake',
            'jwt' => 'Greška sa tokenom'
        ];
    }
}
