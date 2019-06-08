<?php

namespace App\Http\Requests;


class UsuarioRequest extends BaseFormRequest
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
                    'slt_perfil' => 'required',
                    'nome' => 'required|max:150',
                    'email' => 'required|max:200|unique:usuario,email',
                    'senha' => 'required|max:300',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'slt_perfil' => 'required',
                    'nome' => 'required|max:150',
                    'email' => 'required|max:200|unique:usuario, email,' + $this->input('email') + ', pk_usuario',
                    'senha' => 'required|max:300',
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'slt_perfil' => 'Perfil',
            'nome' => 'Modelo',
            'email' => 'Observação',
            'senha' => 'Placa',
        ];
    }
}
