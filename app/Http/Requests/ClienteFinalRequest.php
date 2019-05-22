<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClienteFinalRequest extends BaseFormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'nome_fantasia' => 'required|max:200',
                    'razao_social' => 'required|max:300',
                    'email' => 'required|email|unique:cliente_final|max:100',
                    'telefone1' => 'required|numeric|digits_between:8,15',
                    'telefone2' => 'numeric|digits_between:8,15',
                    'cidade' => 'required|max:150',
                    'estado' => 'required|max:50',
                    'cep' => 'numeric|digits:8',
                    'bairro' => 'max:150',
                    'rua' => 'max:150',
                    'logradouro' => 'max:200',
                    'complemento' => 'max:300',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'nome_fantasia' => 'required|max:200',
                    'razao_social' => 'required|max:300',
                    'email' => 'required|email|max:100|unique:cliente_final,email,'.$this->pk_cliente_final,
                    'telefone1' => 'required|numeric|digits_between:8,15',
                    'telefone2' => 'numeric|digits_between:8,15',
                    'cidade' => 'required|max:150',
                    'estado' => 'required|max:50',
                    'cep' => 'integer|max:8',
                    'bairro' => 'max:150',
                    'rua' => 'max:150',
                    'logradouro' => 'max:200',
                    'complemento' => 'max:300',
                ];
            }
            default:break;
        }
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
