<?php

namespace App\Http\Requests;

use App\Rota;

class RotaRequest extends BaseFormRequest
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
                    'nome' => 'required|unique:rota,nome|max:100',
                    'observacao' => 'max:500'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $id = Rota::find($this->input('id'));
                return [
                    'nome' => 'required|max:100|unique:rota,nome,'.$id,
                    'observacao' => 'max:500'
                ];
            }
            default:break;
        }
        return [
            'nome' => 'unique|max:100',
            'observacao' => 'max:500'
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'observacao' => 'Observação'
        ];
    }
}
