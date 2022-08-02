<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtivosPaisNascimentoRequest extends FormRequest
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
            'vinculo' => ['required','in:ALUNOGR,ALUNOPOS,ALUNOCEU,ALUNOPD,DOCENTE'],
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
            'vinculo.in' => 'O tipo de vínculo tem que ser ALUNOGR, ALUNOPOS, ALUNOCEU, ALUNOPD ou DOCENTE',
            'vinculo.required'  => 'O tipo de vínculo é obrigatório',
        ];
    }
}
