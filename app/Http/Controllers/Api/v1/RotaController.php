<?php

namespace App\Http\Controllers\Api\v1;

use App\Rota;
use Illuminate\Http\Request;
use App\Http\Requests\RotaRequest;

class RotaController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
            'pk_rota',
            'nome',
            'observacao',
            'ativo'
        ];

        $totalData = Rota::count();

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
            $model = Rota::offset($start)
                ->where('ativo', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $model =  Rota::where('pk_rota', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Rota::where('pk_rota', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $nestedData['pk_rota']      = $obj->pk_rota;
                $nestedData['nome']         = $obj->nome;
                $nestedData['observacao']   = $obj->observacao;
                $nestedData['ativo']        = $obj->ativo;
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

        echo json_encode($json_data);
    }

    public function store(RotaRequest $request)
    {
        $validate = $request->validated();

        $model = new Rota();
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

    public function show($id)
    {
        $model = Rota::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Rota não encontrada'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    public function update(RotaRequest $request, $id)
    {
        $model = Rota::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Rota não encontrada'
            ]);
        }

        $validate = $request->validated();

        $success = Rota::create($validate->toArray());

        if($success) {
            return response()->json([
                'success' => $success,
                'message' => 'Edição realizada com sucesso'
            ]);
        } else {
            return response()->json([
                'success' => $success,
                'message' => 'Falha ao realizar a edição. Por favor, tente novamente'
            ]);
        }
    }

    public function destroy($id)
    {
        $model = Rota::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Rota não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $model->ativo = false;
        $success = $model->save();

        if($success) {
            return response()->json([
                'hasSuccess' => $success,
                'message' => 'Exclusão realizada com sucesso'
            ]);
        } else {
            return response()->json([
                'hasSuccess' => $success,
                'message' => 'Falha ao realizar a exclusão. Por favor, tente novamente'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }
    }
}
