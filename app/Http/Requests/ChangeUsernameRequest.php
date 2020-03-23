<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUsernameRequest extends FormRequest
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
            'username' => 'required|min:6|max:20'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Obavezan unos korisničkog imena',
            'username.min' => 'Korisničko ime mora imati najmanje :min karaktera',
            'username.max' => 'Korisničko ime moze imati najviše :max karaktera'
        ]; // TODO: Change the autogenerated stub
    }
}
