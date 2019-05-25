<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends BaseFormRequest
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
            'modelo' => 'required|max:100',
            'observacao' => '',
            'placa' => 'required|max:10',
            'tipo' => 'max:50'
        ];
    }

    public function attributes()
    {
        return [
            'modelo' => 'Modelo',
            'observacao' => 'Observação',
            'placa' => 'Placa',
            'tipo' => 'Tipo'
        ];
    }
}
