<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtivosPorGeneroRequest extends FormRequest
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
            'vinculo' => ['required', 'in:ALUNOGR,ALUNOPOS,ALUNOCEU,ALUNOPD,DOCENTE,ESTAGIARIORH,SERVIDOR,CHEFESADM,CHEFESDPTO,COORD'],
            'curso' => ['nullable', 'integer', 'in:8010,8021,8030,8040,8051'],
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
            'vinculo.in' => 'O tipo de vínculo tem que ...',
            'vinculo.required'  => 'O tipo de vínculo é obrigatório',
        ];
    }
}
