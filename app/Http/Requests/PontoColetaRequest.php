<?php

namespace App\Http\Requests;

class PontoColetaRequest extends BaseFormRequest
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
                    'nome' => 'required|unique:ponto_coleta,nome|max:100',
                    'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'unique:ponto_coleta,latitude'],
                    'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'unique:ponto_coleta,longitude'],
                    'descricao' => 'max:300'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'nome' => 'required|unique:ponto_coleta,nome|max:100',
                    'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'unique:ponto_coleta,latitude'],
                    'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'unique:ponto_coleta,longitude'],
                    'descricao' => 'max:300'
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'descricao' => 'Descrição',
            'ativo' => 'Ativo'
        ];
    }
}
