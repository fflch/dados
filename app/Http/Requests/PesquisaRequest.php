<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesquisaRequest extends FormRequest
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
            'ano' => 'nullable|integer',
            'ano_ini' => 'nullable|integer',
            'ano_fim' => 'nullable|integer',
            'tipo' => 'nullable|in:anual,periodo,ativo,tudo',
            'filtro' => 'nullable|in:departamento,curso,serie_historica',
            'serie_historica_tipo' => 'nullable|in:departamento,curso',
            
        ];
    }

    
}
