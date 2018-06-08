<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class AuthRequest extends FormRequest
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
            'email'   =>'required',
            'password'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Informe o e-mail',
            'password.required' => 'Informe a senha',
        ];
    }
}
