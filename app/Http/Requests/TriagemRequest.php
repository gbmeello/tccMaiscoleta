<?php

namespace App\Http\Requests;


class TriagemRequest extends BaseFormRequest
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
                    'slt_coleta' => 'required',
                    'slt_cliente_final' => 'required',
                    'slt_tipo_residuo' => 'required',
                    'data_triagem' => 'required',
                    'data_venda' => 'required',
                    'peso' => 'required',
                    'observacao' => 'max:600'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'slt_coleta' => 'required',
                    'slt_cliente_final' => 'required',
                    'slt_tipo_residuo' => 'required',
                    'data_triagem' => 'required',
                    'data_venda' => 'required',
                    'peso' => 'required',
                    'observacao' => 'max:600'
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'slt_coleta' => 'Coleta',
            'slt_cliente_final' => 'Cliente Final',
            'slt_tipo_residuo' => 'Tipo de Resíduo',
            'data_triagem' => 'Data de Triagem',
            'data_venda' => 'Data de Venda',
            'peso' => 'Peso',
            'observacao' => 'Observação'
        ];
    }
}
