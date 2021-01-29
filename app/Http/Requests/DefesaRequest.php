<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Defesa;

class DefesaRequest extends FormRequest
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
            'ano' => ['nullable','integer',Rule::in(Defesa::anos())],
            'codcur' => ['nullable','integer',Rule::in(Defesa::listarCodcur())],
        ];

        return $rules;
    }
}
