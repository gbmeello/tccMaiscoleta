<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FardoRequest extends BaseFormRequest
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
                    'slt_tipo_residuo' => 'required',
                    'slt_cliente_final' => 'required',
                    'slt_triagem' => 'required',
                    'lote' => 'required',
                    'data_venda' => 'required',
                    'peso' => 'required',
                    'unidade_medida' => 'required|in:g,kg,ton',
                    'observacao' => 'max:1000',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'slt_tipo_residuo' => 'required',
                    'slt_cliente_final' => 'required',
                    'slt_triagem' => 'required',
                    'lote' => 'required',
                    'data_venda' => 'required',
                    'peso' => 'required',
                    'unidade_medida' => 'required|in:g,kg,ton',
                    'observacao' => 'max:1000',
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'slt_tipo_residuo' => 'Tipo de Resíduo',
            'slt_cliente_final' => 'Cliente Final',
            'slt_triagem' => 'Triagem',
            'slt_unidade_medida' => 'Unidade de Medida',
            'lote' => 'Lote',
            'data_venda' => 'Data de Venda',
            'peso' => 'Peso',
            'observacao' => 'Observação'
        ];
    }
}
