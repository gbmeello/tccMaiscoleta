<?php

namespace App\Http\Controllers\Api\v1;

use App\Veiculo;
use App\Helper\Helpers;
use Illuminate\Http\Request;
use App\Http\Requests\VeiculoRequest;

class VeiculoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $totalData      = Veiculo::where('ativo', '=', true)->count();
        $totalFiltered  = $totalData;
        $columnOrder    = ($request->input('order.0.column') == $columns[0] ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = (empty($request->input('order.0.dir')) ? 'asc' : $request->input('order.0.dir'));
        $models = null;

        if(empty($request->input('search.value'))) {
            $models = Veiculo::offset($start)
                ->where('ativo', true)
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
                ->where('ativo', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Veiculo::where('pk_veiculo', 'LIKE', "%{$search}%")
                ->orWhere('modelo', 'LIKE',"%{$search}%")
                ->orWhere('observacao', 'LIKE',"%{$search}%")
                ->orWhere('placa', 'LIKE',"%{$search}%")
                ->orWhere('tipo', 'LIKE',"%{$search}%")
                ->where('ativo', true)
                ->count();
        }

        $data = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $nestedData['pk_veiculo']   = $model->pk_veiculo;
                $nestedData['modelo']       = $model->modelo;
                $nestedData['observacao']   = $model->observacao;
                $nestedData['placa']        = $model->placa;
                $nestedData['tipo']         = $model->tipo;
                $nestedData['ativo']        = $model->ativo;
                $data[]                     = $nestedData;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VeiculoRequest $request)
    {
        $validate = $request->validated();

        $model = new Veiculo();
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
        $model = Veiculo::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não existe'
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
    public function update(VeiculoRequest $request, $id)
    {
        $model = Veiculo::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Veículo não existe'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
