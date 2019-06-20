<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends BaseFormRequest
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
                    'slt_municipio' => 'required|integer',
                    'nome_fantasia' => 'required|unique:fornecedor|max:200',
                    'razao_social' => 'required|max:300',
                    'email' => 'required|email|unique:fornecedor|max:100',
                    'telefone1' => 'max:15',
                    'telefone2' => 'max:15',
                    'cep' => 'max:9',
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
                    'slt_municipio' => 'required|integer',
                    'nome_fantasia' => 'required|max:200|unique:fornecedor,nome_fantasia,'.$this->input('id').',pk_fornecedor',
                    'razao_social' => 'required|max:300',
                    'email' => 'required|email|max:100|unique:fornecedor,email,'.$this->input('id').',pk_fornecedor',
                    'telefone1' => 'max:15',
                    'telefone2' => 'max:15',
                    'cep' => 'max:9',
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
            'slt_municipio' => 'Município',
            'nome_fantasia' => 'Nome Fantasia',
            'razao_social' => 'Razão Social',
            'email' => 'Email',
            'telefone1' => 'Telefone 1',
            'telefone2' => 'Telefone 2',
            'cep' => 'CEP',
            'bairro' => 'Bairro',
            'rua' => 'Rua',
            'logradouro' => 'Logradouro',
            'complemento' => 'Complemento'
        ];
    }
}
