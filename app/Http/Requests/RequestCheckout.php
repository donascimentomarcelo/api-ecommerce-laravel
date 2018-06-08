<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class RequestCheckout extends FormRequest
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
            'cupom_code'         => 'exists:cupoms,code,used,0',
            'items.0'            => 'required|array|min:1',
            'items.0.product_id' => 'required',
            'items.0.order_id'   => 'required',
            'items.0.qtd'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cupom_code.exists'           => 'O cupom não existe ou já foi usado',
            'items.0.required'            => 'Insira os itens na sua compra',
            'items.0.product_id.required' => 'product_id não foi informado',
            'items.0.order_id.required'   => 'order_id não foi informado',
            'items.0.qtd.required'        => 'Informe a quantidade',
        ];
    }
}
