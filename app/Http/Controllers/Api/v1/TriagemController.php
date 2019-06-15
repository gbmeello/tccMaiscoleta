<?php

namespace App\Http\Controllers\Api\v1;

use App\Triagem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TriagemRequest;

class TriagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            'pk_triagem',
            'fk_coleta',
            'data_triagem',
            'observacao',
            'ativo'
        ];

        $totalData = Triagem::count();

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
            $model = Triagem::offset($start)
                ->where('ativo', '=', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model = Triagem::from('triagem as t')
                ->select(
                    't.*',
                    'c.data_coleta as c_data_coleta',
                    'r.nome as r_nome',
                    'v.placa as v_placa',
                    'v.modelo as v_modelo')
                ->leftJoint('coleta as c', 'c.pk_coleta', '=', 't.fk_coleta')
                ->leftJoint('rota as r', 'r.pk_rota', '=', 'c.fk_rota')
                ->leftJoint('veiculo as v', 'v.pk_veiculo', '=', 'r.fk_veiculo')
                ->where('t.pk_triagem', 'LIKE', "%{$search}%")
                ->orWhere('t.data_triagem', 'LIKE',"%{$search}%")
                ->orWhere('t.observacao', 'LIKE',"%{$search}%")
                ->where('t.ativo', '=', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Triagem::from('triagem as t')
                ->select(
                    't.*',
                    'c.data_coleta as c_data_coleta',
                    'r.nome as r_nome',
                    'v.placa as v_placa',
                    'v.modelo as v_modelo')
                ->leftJoint('coleta as c', 'c.pk_coleta', '=', 't.fk_coleta')
                ->leftJoint('rota as r', 'r.pk_rota', '=', 'c.fk_rota')
                ->leftJoint('veiculo as v', 'v.pk_veiculo', '=', 'r.fk_veiculo')
                ->where('t.pk_triagem', 'LIKE', "%{$search}%")
                ->orWhere('t.data_triagem', 'LIKE',"%{$search}%")
                ->orWhere('t.observacao', 'LIKE',"%{$search}%")
                ->where('t.ativo', '=', true)
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $nestedData['pk_triagem']       = $obj->pk_triagem;
                $nestedData['fk_coleta']        = $obj->fk_coleta;
                $nestedData['data_triagem']     = $obj->data_triagem;
                $nestedData['observacao']       = $obj->observacao;
                $nestedData['ativo']            = $obj->ativo;

                $nestedData['c_data_coleta']    = $obj->c_data_coleta;
                $nestedData['r_nome']           = $obj->r_nome;
                $nestedData['v_placa']          = $obj->v_placa;
                $nestedData['v_modelo']         = $obj->v_modelo;
                $nestedData['v_veicuo']         = $obj->v_placa.'/'.$obj->v_modelo;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TriagemRequest $request)
    {
        $validate = $request->validated();

        $model = new Triagem();
        $model->setColetaAttribute($validate['slt_coleta']);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Triagem::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Triagem não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TriagemRequest $request, $id)
    {
        $model = Triagem::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Triagem não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $validate = $request->validated();

        $model->setColetaAttribute($validate['slt_coleta']);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Triagem::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'O Triagem não existe'
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
