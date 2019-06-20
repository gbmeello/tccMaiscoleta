<?php

namespace App\Http\Requests;


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
                    'modelo' => 'required|max:100',
                    'observacao' => '',
                    'placa' => 'required|max:10,unique:veiculo',
                    'tipo' => 'max:50'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'modelo' => 'required|max:100',
                    'observacao' => '',
                    'placa' => 'required|max:10|unique:veiculo,placa,'.$this->input('id').',pk_veiculo',
                    'tipo' => 'max:50'
                ];
            }
            default:break;
        }
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
