<?php

namespace App\Http\Controllers\Api\v1;

use App\TipoResiduo;
use Illuminate\Http\Request;
use App\Http\Requests\TipoResiduoRequest;

class TipoResiduoController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
           'pk_tipo_residuo',
           'nome',
           'descricao',
           'ativo'
        ];

        $totalData = TipoResiduo::count();

        $totalFiltered = $totalData;

        $columnOrder = ($request->input('order.0.column') == $columns[0] ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = (empty($request->input('order.0.dir')) ? 'asc' : $request->input('order.0.dir'));
        $models = null;
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $models = TipoResiduo::offset($start)
                ->where('ativo', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $models = TipoResiduo::where('pk_tipo_residuo', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = TipoResiduo::where('pk_tipo_residuo', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->count();
        }

        $data = [];
        if(!empty($models))
        {
            foreach ($models as $tipoResiduo)
            {
                $nestedData['pk_tipo_residuo']  = $tipoResiduo->pk_tipo_residuo;
                $nestedData['nome']             = $tipoResiduo->nome;
                $nestedData['descricao']        = $tipoResiduo->descricao;
                $nestedData['ativo']            = $tipoResiduo->ativo;
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

    public function store(TipoResiduoRequest $request)
    {
        $validate = $request->validated();

        $model = new TipoResiduo();
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
        $model = TipoResiduo::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de resíduo não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    public function update(TipoResiduoRequest $request, $id)
    {
        $model = TipoResiduo::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de resíduo não existe'
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
        $model = TipoResiduo::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de Resíduo não existe'
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
