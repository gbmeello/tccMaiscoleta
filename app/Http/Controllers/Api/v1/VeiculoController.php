<?php

namespace App\Http\Controllers\Api\v1;

use App\TipoResiduo;
use App\Veiculo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VeiculoController extends ApiController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modelo' => 'required|max:100',
            'observacao' => '',
            'placa' => 'required|max:10',
            'tipo' => 'max:50'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();
            return response()->json($mensagens, 400);
        }

        $veiculo = new Veiculo();
        $hasSuccess = $veiculo->fill($request->all())->save();

        if($hasSuccess) {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Cadastro realizado com sucesso'
            ], 200);
        } else {
            return response()->json([
                'hasSuccess' => $hasSuccess,
                'message' => 'Falha ao realizar o cadastro. Por favor, tente novamente'
            ], 400);
        }
    }

    public function list(Request $request)
    {
        $columns = [
            0 => 'pk_veiculo',
            1 => 'modelo',
            2 => 'observacao',
            3 => 'placa',
            4 => 'tipo',
            5 => 'ativo'
        ];

        $totalData      = Veiculo::count();
        $totalFiltered  = $totalData;
        $columnOrder    = ($request->input('order.0.column') == 'id' ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = (empty($request->input('order.0.dir')) ? 'asc' : $request->input('order.0.dir'));
        $models = null;

        if(empty($request->input('search.value'))) {
            $models = Veiculo::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $models = Veiculo::where('pk_veiculo', 'LIKE', "%{$search}%")
                ->orWhere('modelo', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->orWhere('placa', 'LIKE',"%{$search}%")
                ->orWhere('tipo', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Veiculo::where('pk_veiculo', 'LIKE', "%{$search}%")
                ->orWhere('modelo', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->orWhere('placa', 'LIKE',"%{$search}%")
                ->orWhere('tipo', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $nestedData['id']           = $model->pk_veiculo;
                $nestedData['modelo']       = $model->modelo;
                $nestedData['observacao']   = $model->observacao;
                $nestedData['placa']        = $model->placa;
                $nestedData['tipo']         = $model->tipo;
                $nestedData['ativo']        = $model->ativo;
                $data[]                     = $nestedData;
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

    public function update(Request $request, Veiculo $model)
    {
        $model = Veiculo::find($model->pk_veiculo);
        if(empty($model)) {
            echo 'nop';
            return;
        }

        $validator = Validator::make($request->all(), [
            'modelo' => 'required|max:100',
            'observacao' => '',
            'placa' => 'required|max:10',
            'tipo' => 'max:50'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'hasSuccess' => false,
                'message' => $mensagens
            ]);
        }

        dd($request->all());

        $veiculo = new Veiculo();
        $hasSuccess = $veiculo->fill($request->all())->save();

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

    public function delete($id)
    {
        $model = Veiculo::find($id);
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
