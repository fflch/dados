<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Defesa;

class AlunosAtivosPorCursoRequest extends FormRequest
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
            'tipvin' => ['required','in:ALUNOGR,ALUNOPD'],
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
            'tipvin.in' => 'O tipo de vínculo tem que ser ALUNOGR (aluno de graduação) ou ALUNOPD (aluno de pós doutorado)',
            'tipvin.required'  => 'O tipo de vínculo é obrigatório',
        ];
    }
}
