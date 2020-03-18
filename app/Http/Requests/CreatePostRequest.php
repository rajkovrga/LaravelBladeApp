<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|min:6',
            'desc' => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Obavezno uneti naslov',
            'desc.required' => 'Obavezno uneti opis',
            'title.min' => 'Naslov mora biti duzi od :min karaktera',
            'desc.min' => 'Opis mora biti duzi od :min karaktera',
        ];
    }
}
