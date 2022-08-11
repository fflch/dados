<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlunosAtivosAutodeclaradosRequest extends FormRequest
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
        $rules = [
            'vinculo' => ['required', Rule::in('ALUNOGR','ALUNOPOS','ALUNOPD','ALUNOCEU')],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'vinculo.in' => 'O tipo de vínculo tem que ser ALUNOGR, ALUNOPOS, ALUNOPD ou ALUNOCEU',
            'vinculo.required'  => 'O tipo de vínculo é obrigatório',
        ];
    }
}
