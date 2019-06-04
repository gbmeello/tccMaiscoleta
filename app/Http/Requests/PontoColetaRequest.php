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
        $models = ['data' => json_decode($this->input('json'))];
        $this->merge($models);

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
                    'data.*.nome' => 'required|unique:ponto_coleta,nome|max:100',
                    'data.*.latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'unique:ponto_coleta,latitude'],
                    'data.*.longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'unique:ponto_coleta,longitude'],
                    'data.*.descricao' => 'max:300'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'data.*.nome' => 'required|max:100|unique:ponto_coleta,nome,' + $this->input('id') + ',pk_ponto_coleta',
                    'data.*.latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'unique:ponto_coleta, latitude,' + $this->input('id') + ', pk_ponto_coleta'],
                    'data.*.longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'unique:ponto_coleta, longitude,' + $this->input('id') + ', pk_ponto_coleta'],
                    'data.*.descricao' => 'max:300'
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
