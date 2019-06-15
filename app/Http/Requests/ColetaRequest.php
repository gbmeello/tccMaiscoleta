<?php

namespace App\Http\Requests;


class ColetaRequest extends BaseFormRequest
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
                    'slt_rota' => 'required',
                    'data_coleta' => 'required',
                    // 'has_coleta' => 'required',
                    'observacao' => 'max:1000'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'slt_rota' => 'required',
                    'data_coleta' => 'required',
                    // 'has_coleta' => 'required',
                    'observacao' => 'max:1000'
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'slt_rota' => 'Rota',
            'data_coleta' => 'Data de Coleta',
            // 'has_coleta' => 'Teve coleta?',
            'observacao' => 'Observação'
        ];
    }
}
