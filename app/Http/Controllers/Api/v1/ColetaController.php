<?php

namespace App\Http\Controllers\Api\v1;

use App\TipoResiduo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ColetaController extends ApiController
{
    public function index()
    {
        return response()->json([
            'message' => 'Great success! New TipoResiduo created',
            'TipoResiduo' => 1
        ]);
    }

    public function stores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:100',
            'descricao' => 'required|max:600'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'success' => false,
                'message' => $mensagens
            ]);
        }

        $tipoResiduo = new TipoResiduo();
        $tipoResiduo->nome = $request->get('nome');
        $tipoResiduo->descricao = $request->get('descricao');
        $success = $tipoResiduo->save();

        if($success) {
            return response()->json([
                'success' => $success,
                'message' => 'Cadastro realizado com sucesso'
            ]);
        } else {
            return response()->json([
                'success' => $success,
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
        $tipoResiduos  = null;
        //$totalFiltered = null;

        if(empty($request->input('search.value')))
        {
            $tipoResiduos = TipoResiduo::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $tipoResiduos =  TipoResiduo::where('pk_tipo_residuo', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = TipoResiduo::where('pk_tipo_residuo', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->orWhere('ativo', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = [];
        if(!empty($tipoResiduos))
        {
            foreach ($tipoResiduos as $tipoResiduo)
            {
                $nestedData['id']           = $tipoResiduo->pk_tipo_residuo;
                $nestedData['nome']             = $tipoResiduo->nome;
                $nestedData['descricao']        = $tipoResiduo->descricao;
                $nestedData['status']           = $tipoResiduo->status;
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
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:100',
            'descricao' => 'max:600'
        ]);

        if ($validator->fails()) {
            $mensagens = $validator->errors()->messages();

            return response()->json([
                'success' => false,
                'message' => $mensagens
            ]);
        }

        $tipoResiduo = new TipoResiduo();
        $tipoResiduo->nome = $request->get('nome');
        $tipoResiduo->descricao = $request->get('descricao');
        $success = $tipoResiduo->save();

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
        $model = TipoResiduo::find($id);
        if(empty($model)) {
            echo 'nop';
            return;
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
            ]);
        }
    }
}
