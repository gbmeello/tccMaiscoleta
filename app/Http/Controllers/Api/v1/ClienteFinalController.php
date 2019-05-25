<?php

namespace App\Http\Controllers\Api\v1;

use App\ClienteFinal;
use App\Http\Requests\ClienteFinalRequest;

class ClienteFinalController extends ApiController
{
    public function store(ClienteFinalRequest $request)
    {
        $validate = $request->validated();

        $model = new ClienteFinal();
        $success = $model->fill($validate)->save();

        if($success) {
            return response()->json([
                'success' => $success,
                'message' => 'Cadastro realizado com sucesso'
            ]);
        } else {
            return response()->json([
                'success' => $success,
                'message' => 'Falha ao realizar o cadastro. Por favor, tente novamente'
            ], ApiController::HTTP_STATUS_BAD_REQUEST);
        }
    }

    public function list(Request $request)
    {
        $columns = [
            'pk_cliente_final',
            'nome_fantasia',
            'razao_social',
            'email',
            'telefone1',
            'telefone2',
            'cidade',
            'estado',
            'cep',
            'bairro',
            'rua',
            'logradouro',
            'complemento',
            'ativo'
        ];

        $totalData = ClienteFinal::count();

        $totalFiltered = $totalData;

        $columnOrder = ($request->input('order.0.column') == 'id' ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = $request->input('order.0.dir');
        $model  = null;
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $model = ClienteFinal::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model =  ClienteFinal::where('pk_fornecedor', 'LIKE', "%{$search}%")
                ->orWhere('nome_fantasia', 'LIKE',"%{$search}%")
                ->orWhere('razao_social', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('telefone1', 'LIKE',"%{$search}%")
                ->orWhere('telefone2', 'LIKE',"%{$search}%")
                ->orWhere('cidade', 'LIKE',"%{$search}%")
                ->orWhere('estado', 'LIKE',"%{$search}%")
                ->orWhere('cep', 'LIKE',"%{$search}%")
                ->orWhere('bairro', 'LIKE',"%{$search}%")
                ->orWhere('rua', 'LIKE',"%{$search}%")
                ->orWhere('logradouro', 'LIKE',"%{$search}%")
                ->orWhere('complemento', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = ClienteFinal::where('pk_fornecedor', 'LIKE', "%{$search}%")
                ->orWhere('nome_fantasia', 'LIKE',"%{$search}%")
                ->orWhere('razao_social', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('telefone1', 'LIKE',"%{$search}%")
                ->orWhere('telefone2', 'LIKE',"%{$search}%")
                ->orWhere('cidade', 'LIKE',"%{$search}%")
                ->orWhere('estado', 'LIKE',"%{$search}%")
                ->orWhere('cep', 'LIKE',"%{$search}%")
                ->orWhere('bairro', 'LIKE',"%{$search}%")
                ->orWhere('rua', 'LIKE',"%{$search}%")
                ->orWhere('logradouro', 'LIKE',"%{$search}%")
                ->orWhere('complemento', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $nestedData['id']               = $obj->pk_fornecedor;
                $nestedData['nome_fantasia']    = $obj->nome_fantasia;
                $nestedData['razao_social']     = $obj->razao_social;
                $nestedData['email']            = $obj->email;
                $nestedData['telefone1']        = $obj->telefone1;
                $nestedData['telefone2']        = $obj->telefone2;
                $nestedData['cidade']           = $obj->cidade;
                $nestedData['estado']           = $obj->estado;
                $nestedData['cep']              = $obj->cep;
                $nestedData['bairro']           = $obj->bairro;
                $nestedData['rua']              = $obj->rua;
                $nestedData['logradouro']       = $obj->logradouro;
                $nestedData['complemento']      = $obj->complemento;
                $nestedData['ativo']            = $obj->ativo;
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $data
        ];

        echo json_encode($json_data);
    }

    public function update(ClienteFinalRequest $request, $id)
    {
        $model = ClienteFinal::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente Final não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $success = $model->fill($request->toArray())->save();

        if($success) {
            return response()->json([
                'success' => $success,
                'message' => 'Edição realizada com sucesso'
            ]);
        } else {
            return response()->json([
                'success' => $success,
                'message' => 'Falha ao realizar a edição. Por favor, tente novamente'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }
    }

    public function delete($id)
    {
        $model = ClienteFinal::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente Final não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $model->ativo = false;
        $hasSuccess = $model->save();

        if($hasSuccess) {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Exclusão realizada com sucesso'
            ]);
        } else {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Falha ao realizar a exclusão. Por favor, tente novamente'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }
    }
}
