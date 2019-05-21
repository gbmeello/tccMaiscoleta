<?php

namespace App\Http\Controllers\Api\v1;

use App\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FornecedorStoreRequest;
use App\Http\Requests\FornecedorUpdateRequest;

class FornecedorController extends ApiController
{
    public function store(FornecedorStoreRequest $request)
    {
        $validate = $request->validated();

        dd($validate);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'hasSuccess' => false,
                'message' => $validate
            ]);
        }

        $model = new Fornecedor();
        $hasSuccess = $model->fill($request->toArray())->save();

        if($hasSuccess) {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Cadastro realizado com sucesso'
            ]);
        } else {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Falha ao realizar o cadastro. Por favor, tente novamente'
            ]);
        }
    }

    public function list(Request $request)
    {
        $columns = [
            'pk_fornecedor',
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

        $totalData = Fornecedor::count();

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
            $model = Fornecedor::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model =  Fornecedor::where('pk_fornecedor', 'LIKE', "%{$search}%")
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

            $totalFiltered = Fornecedor::where('pk_fornecedor', 'LIKE', "%{$search}%")
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
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        echo json_encode($json_data);
    }

    public function update(FornecedorUpdateRequest $request, $id)
    {
        $model = Fornecedor::find($id);
        if(empty($model)) {
            return response()->json([
                'hasSuccess' => false,
                'message' => 'fornecedor não encontrado'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:100',
            'descricao' => 'max:600'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'hasSuccess' => false,
                'message' => $mensagens
            ]);
        }

        $hasSuccess = $model->fill($request->toArray())->save();

        if($hasSuccess) {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Edição realizada com sucesso'
            ]);
        } else {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Falha ao realizar a edição. Por favor, tente novamente'
            ]);
        }
    }

    public function delete($id)
    {
        $model = Fornecedor::find($id);
        if(empty($model)) {
            echo 'nop';
            return;
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
            ]);
        }
    }
}
