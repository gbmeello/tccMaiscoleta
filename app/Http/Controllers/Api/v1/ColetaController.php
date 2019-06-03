<?php

namespace App\Http\Controllers\Api\v1;

use App\Coleta;
use Illuminate\Http\Request;
use App\Http\Requests\ColetaRequest;

class ColetaController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
           'pk_coleta',
           'nome',
           'descricao',
           'ativo'
        ];

        $totalData = Coleta::count();

        $totalFiltered = $totalData;

        $columnOrder = ($request->input('order.0.column') == 'id' ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = (empty($request->input('order.0.dir')) ? 'asc' : $request->input('order.0.dir'));
        $models = null;
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $models = Coleta::offset($start)
                ->where('ativo', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $models = Coleta::where('pk_coleta', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Coleta::where('pk_coleta', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->count();
        }

        $data = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $nestedData['pk_coleta']  = $model->pk_coleta;
                $nestedData['nome']       = $model->nome;
                $nestedData['descricao']  = $model->descricao;
                $nestedData['ativo']      = $model->ativo;
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

    public function store(ColetaRequest $request)
    {
        $validate = $request->validated();

        $model = new Coleta();
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
        $model = Coleta::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Coleta não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => false,
            'data' => $model
        ]);
    }

    public function update(ColetaRequest $request, $id)
    {
        $model = Coleta::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Coleta não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $validate = $request->validated();

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
        $model = Coleta::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Coleta não existe'
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
