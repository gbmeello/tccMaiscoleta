<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorUpdateRequest extends FormRequest
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
            'nome_fantasia' => 'required|max:200',
            'razao_social' => 'required|max:300',
            'email' => 'required|email|max:100',
            'telefone1' => 'required|max:15',
            'telefone2' => 'max:15',
            'cidade' => 'required|max:150',
            'estado' => 'required|max:50',
            'cep' => 'max:8',
            'bairro' => 'max:150',
            'rua' => 'max:150',
            'logradouro' => 'required|max:200',
            'complemento' => 'required|max:300'
        ];
    }

    public function attributes()
    {
        return [
            'nome_fantasia' => 'Nome Fantasia',
            'razao_social' => 'Razão Social',
            'email' => 'Email',
            'telefone1' => 'Telefone 1',
            'telefone2' => 'Telefone 2',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'cep' => 'CEP',
            'bairro' => 'Bairro',
            'rua' => 'Rua',
            'logradouro' => 'Logradouro',
            'complemento' => 'Complemento'
        ];
    }
}
