<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ClientRequest extends FormRequest
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
            'name'             => 'required|min:3|max:80',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|between:6,12',
            'password_confirmation' => 'same:password|required|between:6,12',
            'role'             => 'required|in:client,admin',
            'client'           => 'required|array|min:1',
            'client.phone'     => 'required|size:11',
            'client.address'   => 'required|min:3|max:80',
            'client.city'      => 'required|min:3|max:80',
            'client.state'     => 'required|min:2|max:20',
            'client.zipcode'   => 'required|size:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required'           => 'O nome é obrigatório',
            'name.min'                => 'O tamanho mínimo do campo nome são 3 caracteres',
            'name.max'                => 'O tamanho maximo do campo nome são 80 caracteres',

            'email.required'          => 'O e-mail é obrigatório',
            'email.email'             => 'E-mail inválido',
            'email.unique'            => 'E-mail já existente',

            'role.required'           => 'O perfil é obrigatório',
            'role.in'                 => 'Perfil inválido',

            'password.required'       => 'A senha é obrigatória',
            'password.between'        => 'A senha deve ter entre 6 e 12 caracteres',            
            
            'password_confirmation.required'  => 'A confirmação de senha é obrigatória',
            'password_confirmation.between'   => 'A confirmação deve ter entre 6 e 12 caracteres',
            'password_confirmation.same'      => 'As senhas estão diferentes',

            'client.required'         => 'Envie os dados do cliente',

            'client.phone.required'   => 'O telefone é obrigatório',
            'client.phone.size'       => 'Telefone inválido',
            
            'client.address.required' => 'O endereço é obrigatório',
            'client.address.min'      => 'O tamanho mínimo do campo endereço são 3 caracteres',
            'client.address.max'      => 'O tamanho maximo do campo endereço são 80 caracteres',

            'client.city.required'    => 'A cidade é obrigatório',
            'client.city.min'         => 'O tamanho mínimo do campo cidade  são 3 caracteres',
            'client.city.max'         => 'O tamanho maximo do campo cidade  são 80 caracteres',
            
            'client.state.required'   => 'O estado é obrigatório',
            'client.state.min'        => 'O tamanho mínimo do campo estado são 3 caracteres',
            'client.state.max'        => 'O tamanho maximo do campo estado são 20 caracteres',
            
            'client.zipcode.required' => 'O CEP é obrigatório',
            'client.zipcode.size'     => 'CEP inválido',
        ];
    }
}
