<?php

namespace App\Http\Controllers\Api\v1;

use App\Fornecedor;
use Illuminate\Http\Request;
use App\Http\Requests\FornecedorRequest;

class FornecedorController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
            'pk_fornecedor',
            'estado',
            'municipio',
            'nome_fantasia',
            'razao_social',
            'email',
            'telefone1',
            'telefone2',
            'cep',
            'bairro',
            'rua',
            'logradouro',
            'complemento',
            'ativo'
        ];

        $totalData = Fornecedor::count();

        $totalFiltered = $totalData;

        $columnOrder = ($request->input('order.0.column') == $columns[0] ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = $request->input('order.0.dir');
        $model  = null;
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $model = Fornecedor::offset($start)
                ->where('ativo', '=', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model = Fornecedor::from('fornecedor as f')
                ->select('f.*', 'e.nome as estado', 'm.nome as municipio')
                ->leftJoint('municipio as m', 'm.pk_municipio', '=', 'f.fk_municipio')
                ->leftJoint('estado as e', 'e.pk_estado', '=', 'm.fk_estado')
                ->where('f.pk_fornecedor', 'LIKE', "%{$search}%")
                ->orWhere('f.nome_fantasia', 'LIKE',"%{$search}%")
                ->orWhere('e.nome', 'LIKE',"%{$search}%")
                ->orWhere('m.nome', 'LIKE',"%{$search}%")
                ->orWhere('f.razao_social', 'LIKE',"%{$search}%")
                ->orWhere('f.email', 'LIKE',"%{$search}%")
                ->orWhere('f.telefone1', 'LIKE',"%{$search}%")
                ->orWhere('f.telefone2', 'LIKE',"%{$search}%")
                ->orWhere('f.cep', 'LIKE',"%{$search}%")
                ->orWhere('f.bairro', 'LIKE',"%{$search}%")
                ->orWhere('f.rua', 'LIKE',"%{$search}%")
                ->orWhere('f.logradouro', 'LIKE',"%{$search}%")
                ->orWhere('f.complemento', 'LIKE',"%{$search}%")
                ->where('f.ativo', '=', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Fornecedor::from('fornecedor as f')
                ->select('f.*', 'e.nome as estado', 'm.nome as municipio')
                ->leftJoint('municipio as m', 'm.pk_municipio', '=', 'f.fk_municipio')
                ->leftJoint('estado as e', 'e.pk_estado', '=', 'm.fk_estado')
                ->where('f.pk_fornecedor', 'LIKE', "%{$search}%")
                ->orWhere('f.nome_fantasia', 'LIKE',"%{$search}%")
                ->orWhere('e.nome', 'LIKE',"%{$search}%")
                ->orWhere('m.nome', 'LIKE',"%{$search}%")
                ->orWhere('f.razao_social', 'LIKE',"%{$search}%")
                ->orWhere('f.email', 'LIKE',"%{$search}%")
                ->orWhere('f.telefone1', 'LIKE',"%{$search}%")
                ->orWhere('f.telefone2', 'LIKE',"%{$search}%")
                ->orWhere('f.cep', 'LIKE',"%{$search}%")
                ->orWhere('f.bairro', 'LIKE',"%{$search}%")
                ->orWhere('f.rua', 'LIKE',"%{$search}%")
                ->orWhere('f.logradouro', 'LIKE',"%{$search}%")
                ->orWhere('f.complemento', 'LIKE',"%{$search}%")
                ->where('f.ativo', '=', true)
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $municipio = $obj->municipio()->first();
                $estado = $municipio->estado()->first();

                $nestedData['pk_fornecedor']    = $obj->pk_fornecedor;
                $nestedData['estado']           = $estado->nome;
                $nestedData['municipio']        = $municipio->nome;
                $nestedData['nome_fantasia']    = $obj->nome_fantasia;
                $nestedData['razao_social']     = $obj->razao_social;
                $nestedData['email']            = $obj->email;
                $nestedData['telefone1']        = $obj->telefone1;
                $nestedData['telefone2']        = $obj->telefone2;
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
            'success'         => true,
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data'            => $data
        ];

        return response()->json($json_data);
    }

    public function store(FornecedorRequest $request)
    {
        $validate = $request->validated();

        $model = new Fornecedor();
        $model->setMunicipioAttribute($validate['slt_municipio']);

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

    public function show(PontoColetaRequest $id)
    {
        $model = Fornecedor::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Fornecedor não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    public function update(FornecedorRequest $request, $id)
    {
        $model = Fornecedor::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente Final não existe'
            ]);
        }

        $validate = $request->validated();

        $model->setMunicipioAttribute($validate['slt_municipio']);

        $success = $model->fill($validate)->save();

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


    public function destroy($id)
    {
        $model = Fornecedor::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Fornecedor não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $model->ativo = false;
        $success = $model->save();

        if($success) {
            return response()->json([
                'success' => $success,
                'message' => 'Exclusão realizada com sucesso'
            ]);
        } else {
            return response()->json([
                'success' => $success,
                'message' => 'Falha ao realizar a exclusão. Por favor, tente novamente'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }
    }
}
