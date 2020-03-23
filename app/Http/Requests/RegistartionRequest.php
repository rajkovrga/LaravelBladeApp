<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistartionRequest extends FormRequest
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
            'username' => 'required|min:6|max:20',
            'password' => 'required|min:6',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
          'username.required' => 'Obavezan unos korisničkog imena',
            'username.min' => 'Korisničko ime mora imati najmanje :min karaktera',
            'username.max' => 'Korisničko ime mora imati najviše :max karaktera',
            'password.min' => 'Lozinka mora biti duža od :min karaktera',
            'password.required' => 'Obavezan unos lozinke',
            'email.required' => 'Obavezan unos mejla',
            'email' => 'Format mejla nije dobar'
        ];
    }
}
