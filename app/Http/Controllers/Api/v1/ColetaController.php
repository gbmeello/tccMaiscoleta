<?php

namespace App\Http\Controllers\Api\v1;

use App\Coleta;
use Illuminate\Http\Request;
use App\Http\Requests\ColetaRequest;
use Illuminate\Support\Carbon;

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
        $models = [];
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $models = Coleta::from('coleta as c')
                ->select('c.*', 'r.nome', 'r.observacao as rota_observacao', 'v.modelo', 'v.placa', 'f.nome_fantasia')
                ->leftJoin('rota as r', 'r.pk_rota', '=', 'c.fk_rota')
                ->leftJoin('veiculo as v', 'v.pk_veiculo', '=', 'c.fk_veiculo')
                ->leftJoin('fornecedor as f', 'f.pk_fornecedor', '=', 'c.fk_fornecedor')
                ->where('c.ativo', true)
                ->limit($limit)
                ->offset($start)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $models = Coleta::from('coleta as c')
                ->select('c.*', 'r.nome', 'r.observacao as rota_observacao', 'v.modelo', 'v.placa', 'f.nome_fantasia')
                ->leftJoin('rota as r', 'r.pk_rota', '=', 'c.fk_rota')
                ->leftJoin('veiculo as v', 'v.pk_veiculo', '=', 'c.fk_veiculo')
                ->leftJoin('fornecedor as f', 'f.pk_fornecedor', '=', 'c.fk_fornecedor')
                ->where('c.ativo', true)
                ->where('pk_coleta', 'LIKE', "%{$search}%")
                ->orWhere('c.data_coleta', 'LIKE',"%{$search}%")
                ->orWhere('c.has_coleta', 'LIKE',"%{$search}%")
                ->orWhere('c.observacao', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Coleta::from('coleta as c')
                ->select('c.*', 'r.nome', 'r.observacao as rota_observacao', 'v.modelo', 'v.placa', 'f.nome_fantasia')
                ->leftJoin('rota as r', 'r.pk_rota', '=', 'c.fk_rota')
                ->leftJoin('veiculo as v', 'v.pk_veiculo', '=', 'c.fk_veiculo')
                ->leftJoin('fornecedor as f', 'f.pk_fornecedor', '=', 'c.fk_fornecedor')
                ->where('c.ativo', true)
                ->where('pk_coleta', 'LIKE', "%{$search}%")
                ->orWhere('c.data_coleta', 'LIKE',"%{$search}%")
                ->orWhere('c.has_coleta', 'LIKE',"%{$search}%")
                ->orWhere('c.observacao', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $nestedData['pk_coleta']        = $model->pk_coleta;
                $nestedData['data_coleta']      = Carbon::parse($model->data_coleta)->format('d/m/Y');
                $nestedData['has_coleta']       = $model->has_coleta;
                $nestedData['observacao']       = $model->observacao;
                $nestedData['veiculo_modelo']   = $model->modelo;
                $nestedData['veiculo_placa']    = $model->placa;
                $nestedData['fornecedor']       = $model->nome_fantasia;
                $nestedData['rota_nome']        = $model->nome;
                $nestedData['rota_observacao']  = $model->rota_observacao;
                $nestedData['ativo']            = $model->ativo;
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

        $validate['slt_rota']       = isset($validate['slt_rota']) ? $validate['slt_rota'] : null;
        $validate['slt_veiculo']    = isset($validate['slt_veiculo']) ? $validate['slt_veiculo'] : null;
        $validate['slt_fornecedor'] = isset($validate['slt_fornecedor']) ? $validate['slt_fornecedor'] : null;

        $model = new Coleta();
        $model->setRotaAttribute($validate['slt_rota']);
        $model->setVeiculoAttribute($validate['slt_veiculo']);
        $model->setFornecedorAttribute($validate['slt_fornecedor']);
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

        $model->data_coleta = Carbon::parse($model->data_coleta)->format('d/m/Y');

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
        $model->setRotaAttribute($validate['slt_rota']);
        $model->setVeiculoAttribute($validate['slt_veiculo']);
        $model->setFornecedorAttribute($validate['slt_fornecedor']);

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
