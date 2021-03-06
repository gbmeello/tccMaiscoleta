<?php

namespace App\Http\Controllers\Api\v1;

use App\Dashboard\DashboardHelper;
use App\Fardo;
use App\Helper\Helpers;
use Illuminate\Http\Request;
use App\Http\Requests\FardoRequest;
use App\Http\Controllers\Controller;

class FardoController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
            'pk_fardo',
            'fk_cliente_final',
            'fk_triagem',
            'lote',
            'data_venda',
            'peso',
            'unidade_medida',
            'observacao',
            'ativo'
        ];

        $totalData = Fardo::where('ativo', '=', true)->count();

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
            $model = Fardo::from('fardo as f')
                ->offset($start)
                ->select(
                    'f.*', 'tr.nome as tr_nome', 'cf.razao_social as cf_razao_social',
                    't.data_triagem as t_data_triagem', 't.observacao as t_observacao')
                ->leftJoin('tipo_residuo as tr', 'tr.pk_tipo_residuo', '=', 'f.fk_tipo_residuo')
                ->leftJoin('cliente_final as cf', 'cf.pk_cliente_final', '=', 'f.fk_cliente_final')
                ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
                ->where('f.ativo', '=', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model = Fardo::from('fardo as f')
                ->select(
                    'f.*', 'tr.nome as tr_nome', 'cf.razao_social as cf_razao_social',
                    't.data_triagem as t_data_triagem', 't.observacao as t_observacao')
                ->leftJoin('tipo_residuo as tr', 'tr.pk_tipo_residuo', '=', 'f.fk_tipo_residuo')
                ->leftJoin('cliente_final as cf', 'cf.pk_cliente_final', '=', 'f.fk_cliente_final')
                ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
                ->where('f.pk_fardo', 'LIKE', "%{$search}%")
                ->orWhere('f.lote', 'LIKE',"%{$search}%")
                ->orWhere('f.data_venda', 'LIKE',"%{$search}%")
                ->orWhere('f.peso', 'LIKE',"%{$search}%")
                ->orWhere('f.unidade_medida', 'LIKE',"%{$search}%")
                ->orWhere('f.observacao', 'LIKE',"%{$search}%")
                ->where('f.ativo', '=', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Fardo::from('fardo as f')
                ->select(
                    'f.*', 'tr.nome as tr_nome', 'cf.razao_social as cf_razao_social',
                    't.data_triagem as t_data_triagem', 't.observacao as t_observacao')
                ->leftJoin('tipo_residuo as tr', 'tr.pk_tipo_residuo', '=', 'f.fk_tipo_residuo')
                ->leftJoin('cliente_final as cf', 'cf.pk_cliente_final', '=', 'f.fk_cliente_final')
                ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
                ->where('f.pk_fardo', 'LIKE', "%{$search}%")
                ->orWhere('f.lote', 'LIKE',"%{$search}%")
                ->orWhere('f.data_venda', 'LIKE',"%{$search}%")
                ->orWhere('f.peso', 'LIKE',"%{$search}%")
                ->orWhere('f.unidade_medida', 'LIKE',"%{$search}%")
                ->orWhere('f.observacao', 'LIKE',"%{$search}%")
                ->where('f.ativo', '=', true)
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $triagem = $obj->triagem()->first();
                $clienteFinal = $obj->clienteFinal()->first();
                $tipoResiduo = $obj->tipoResiduo()->first();

                $nestedData['pk_fardo']         = $obj->pk_fardo;
                $nestedData['lote']             = $obj->lote;
                $nestedData['data_venda']       = $obj->data_venda;
                $nestedData['peso']             = $obj->peso.$obj->unidade_medida;
                $nestedData['unidade_medida']   = $obj->unidade_medida;
                $nestedData['observacao']       = $obj->observacao;

                if(!empty($tipoResiduo))
                    $nestedData['tr_nome'] = $tipoResiduo->nome;

                if(!empty($clienteFinal))
                    $nestedData['cf_razao_social'] = $clienteFinal->razao_social;

                if(!empty($triagem)) {
                    $nestedData['t_data_triagem'] = $triagem->data_triagem;
                    $nestedData['t_observacao'] = $triagem->observacao;
                }

                $nestedData['ativo'] = $obj->ativo;
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

        return response()->json(Helpers::replaceNullWithEmptyString($json_data));
    }

    public function store(FardoRequest $request)
    {
        $validate = $request->validated();

        $model = new Fardo();
        $model->setUnidadeMedidaAttribute($validate['slt_unidade_medida']);
        $model->setStatusAttribute($validate['slt_status']);
        $model->setTipoResiduoAttribute($validate['slt_tipo_residuo']);
        $model->setClienteFinalAttribute($validate['slt_cliente_final']);
        $model->setTriagemAttribute($validate['slt_triagem']);

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
        $model = Fardo::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'O Fardo não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    public function update(FardoRequest $request, $id)
    {
        $model = Fardo::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'O Fardo não existe'
            ]);
        }

        $validate = $request->validated();

        $model->setUnidadeMedidaAttribute($validate['slt_unidade_medida']);
        $model->setStatusAttribute($validate['slt_status']);
        $model->setTipoResiduoAttribute($validate['slt_tipo_residuo']);
        $model->setClienteFinalAttribute($validate['slt_cliente_final']);
        $model->setTriagemAttribute($validate['slt_triagem']);

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
        $model = Fardo::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'O Fardo não existe'
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

    public function dashboardQuantidade() {

        $data = Fardo::from('fardo as f')
            ->select(
                'f.*',
                'tr.nome as tr_nome',
                'c.razao_social as c_razao_social',
            )
            ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
            ->leftJoin('cliente_final as c', 'c.pk_cliente_final', '=', 'f.fk_cliente_final')
            ->leftJoin('tipo_residuo as tr', 'tr.pk_tipo_residuo', '=', 'f.fk_tipo_residuo')
            ->where('f.ativo', '=', true)
            ->get();

        $data = DashboardHelper::prepareSmallboxInfo($data, "Total", [
            'tr_nome' => 'Tipo de Resíduo',
            'c_razao_social' => 'Cliente - Razão Social',
            'lote' => 'Lote',
            'status' => 'Status',
            'data_venda' => 'Data de Venda' ,
            'peso' => 'Peso',
            'observacao' => 'Observação',
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function dashboardEmEstoque() {

        $data = Fardo::from('fardo as f')
            ->select(
                'f.*',
                'tr.nome as tr_nome',
                'c.razao_social as c_razao_social',
            )
            ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
            ->leftJoin('cliente_final as c', 'c.pk_cliente_final', '=', 'f.fk_cliente_final')
            ->leftJoin('tipo_residuo as tr', 'tr.pk_tipo_residuo', '=', 'f.fk_tipo_residuo')
            ->where('f.status', '=', 'estoque')
            ->where('f.ativo', '=', true)
            ->get();

        $data = DashboardHelper::prepareSmallboxInfo($data, "Estoque", [
            'tr_nome' => 'Tipo de Resíduo',
            'c_razao_social' => 'Cliente - Razão Social',
            'lote' => 'Lote',
            'status' => 'Status',
            'data_venda' => 'Data de Venda' ,
            'peso' => 'Peso',
            'observacao' => 'Observação',
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function dashboardVendido() {


        $data = Fardo::from('fardo as f')
            ->select(
                'f.*',
                'tr.nome as tr_nome',
                'c.razao_social as c_razao_social',
            )
            ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
            ->leftJoin('cliente_final as c', 'c.pk_cliente_final', '=', 'f.fk_cliente_final')
            ->leftJoin('tipo_residuo as tr', 'tr.pk_tipo_residuo', '=', 'f.fk_tipo_residuo')
            ->where('f.status', '=', 'vendido')
            ->where('f.ativo', '=', true)
            ->get();

        $data = DashboardHelper::prepareSmallboxInfo($data, "Vendidos", [
            'tr_nome' => 'Tipo de Resíduo',
            'c_razao_social' => 'Cliente - Razão Social',
            'lote' => 'Lote',
            'status' => 'Status',
            'data_venda' => 'Data de Venda' ,
            'peso' => 'Peso',
            'observacao' => 'Observação',
        ]);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

}
