<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class CupomRequest extends FormRequest
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
            'value' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'O valor é obrigatório',
            'value.numeric'  => 'Insira um valor',
        ];
    }
}
