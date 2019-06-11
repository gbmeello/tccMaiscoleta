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
                    'data_triagem' => 'required',
                    'observacao' => 'max:600'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'slt_coleta' => 'required',
                    'data_triagem' => 'required',
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
            'data_triagem' => 'Data de Triagem',
            'observacao' => 'Observação'
        ];
    }
}
