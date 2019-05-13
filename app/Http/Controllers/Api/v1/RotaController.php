<?php

namespace App\Http\Controllers\Api\v1;

use App\Rota;
use App\TipoResiduo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RotaController extends ApiController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:100',
            'observacao' => 'required|max:500'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'hasSuccess' => false,
                'message' => $mensagens
            ]);
        }

        $hasSuccess = Rota::create($request->all());

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
            0 => 'pk_tipo_residuo',
            1 => 'nome',
            2 => 'descricao',
            3 => 'status'
        ];

        $totalData = TipoResiduo::count();

        $totalFiltered = $totalData;

        $columnOrder = ($request->input('order.0.column') == 'id' ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = $request->input('order.0.dir');
        $rotas  = null;
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $rotas = Rota::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $rotas =  Rota::where('pk_rota', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Rota::where('pk_tipo_residuo', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = [];
        if(!empty($rotas))
        {
            foreach ($rotas as $rota)
            {
                $nestedData['id']           = $rota->pk_tipo_residuo;
                $nestedData['nome']         = $rota->nome;
                $nestedData['observacao']   = $rota->descricao;
                $nestedData['ativo']        = $rota->status;
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

    public function update(Request $request, $id)
    {
        $model = Rota::find($id);
        if(empty($model)) {
            return response()->json([
                'hasSuccess' => false,
                'message' => 'Rota não encontrada'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:100',
            'observacao' => 'required|max:500'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'hasSuccess' => false,
                'message' => $mensagens
            ]);
        }

        $hasSuccess = Rota::create($request->all());

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
        $model = TipoResiduo::find($id);
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
