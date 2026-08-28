<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assunto'   => 'required',
            'descricao' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'assunto.required'   => 'É necessário um assunto para realizar o pedido.',
            'descricao.required' => 'É necessária uma descrição para realizar o pedido.'
        ];
    }
}
