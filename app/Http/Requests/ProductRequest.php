<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id'=>'required',
            'name'       =>'required|min:3|max:80',
            'description'=>'required|min:3|max:80',
            'price'      =>'required|min:1|max:10'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'O category_id é obrigatório',

            'name.required'        => 'O nome é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'price.required'       => 'O preço é obrigatório',

            'name.min'             => 'O tamanho mínimo para o nome são de 3 caracteres',
            'description.min'      => 'O tamanho mínimo para a descrição são de 3 caracteres',
            'price.min'            => 'O tamanho mínimo para o preço é de 1 caracteres',

            'name.max'             => 'O tamanho máximo para o nome são de 80 caracteres',
            'description.max'      => 'O tamanho máximo para a descrição são de 80 caracteres',
            'price.max'            => 'O tamanho máximo para o preço são de 10 caracteres',
        ];
    }
}
