<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoResiduoRequest extends BaseFormRequest
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
                    'nome' => 'required|max:100|unique:tipo_residuo',
                    'descricao' => 'required|max:600'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'nome' => 'required|max:100|unique:tipo_residuo,nome,'.$this->input('id').',pk_tipo_residuo',
                    'descricao' => 'required|max:600'
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'descricao' => 'Descrição'
        ];
    }

}
