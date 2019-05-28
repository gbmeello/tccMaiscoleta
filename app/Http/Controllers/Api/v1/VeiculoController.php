<?php

namespace App\Http\Controllers\Api\v1;

use App\Veiculo;
use Illuminate\Http\Request;
use App\Http\Requests\VeiculoRequest;

class VeiculoController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
            'pk_veiculo',
            'modelo',
            'observacao',
            'placa',
            'tipo',
            'ativo'
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

    public function store(VeiculoRequest $request)
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

    public function update(VeiculoRequest $request, $id)
    {
        $model = Veiculo::find($id);
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

    public function destroy($id)
    {
        $model = Veiculo::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não existe'
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
