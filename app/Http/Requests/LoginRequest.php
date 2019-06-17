<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseFormRequest
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
            'email'  => [
                'required',
                Rule::unique('usuario')->where(function ($query) {
                    $query->where('ativo', true);
                }),
            ],
            'senha' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'Senha' => 'Senha'
        ];
    }
}
