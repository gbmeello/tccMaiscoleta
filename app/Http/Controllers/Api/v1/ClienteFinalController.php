<?php

namespace App\Http\Controllers\Api\v1;

use App\ClienteFinal;
use App\Dashboard\DashboardHelper;
use App\Fardo;
use App\Helper\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteFinalRequest;
use Illuminate\Support\Facades\DB;

class ClienteFinalController extends ApiController
{
    public function index(Request $request)
    {
        $columns = [
            'pk_cliente_final',
            'fk_municipio',
            'nome_fantasia',
            'razao_social',
            'email',
            'telefone1',
            'telefone2',
            'cep',
            'bairro',
            'rua',
            'logradouro',
            'complemento',
            'ativo'
        ];

        $totalData = ClienteFinal::where('ativo', '=', true)->count();

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
            $model = ClienteFinal::from('cliente_final as cf')
                ->select('cf.*', 'e.nome as estado', 'm.nome as municipio')
                ->leftJoin('municipio as m', 'm.pk_municipio', '=', 'cf.fk_municipio')
                ->leftJoin('estado as e', 'e.pk_estado', '=', 'm.fk_estado')
                ->where('ativo', '=', true)
                ->limit($limit)
                ->offset($start)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model = ClienteFinal::from('cliente_final as cf')
                ->select('cf.*', 'e.nome as estado', 'm.nome as municipio')
                ->leftJoin('municipio as m', 'm.pk_municipio', '=', 'cf.fk_municipio')
                ->leftJoin('estado as e', 'e.pk_estado', '=', 'm.fk_estado')
                ->where('cf.pk_cliente_final', 'LIKE', "%{$search}%")
                ->orWhere('cf.nome_fantasia', 'LIKE',"%{$search}%")
                ->orWhere('e.nome', 'LIKE',"%{$search}%")
                ->orWhere('m.nome', 'LIKE',"%{$search}%")
                ->orWhere('cf.razao_social', 'LIKE',"%{$search}%")
                ->orWhere('cf.email', 'LIKE',"%{$search}%")
                ->orWhere('cf.telefone1', 'LIKE',"%{$search}%")
                ->orWhere('cf.telefone2', 'LIKE',"%{$search}%")
                ->orWhere('cf.cep', 'LIKE',"%{$search}%")
                ->orWhere('cf.bairro', 'LIKE',"%{$search}%")
                ->orWhere('cf.rua', 'LIKE',"%{$search}%")
                ->orWhere('cf.logradouro', 'LIKE',"%{$search}%")
                ->orWhere('cf.complemento', 'LIKE',"%{$search}%")
                ->where('cf.ativo', '=', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = ClienteFinal::from('cliente_final as cf')
                ->select('cf.*', 'e.nome as estado', 'm.nome as municipio')
                ->leftJoin('municipio as m', 'm.pk_municipio', '=', 'cf.fk_municipio')
                ->leftJoin('estado as e', 'e.pk_estado', '=', 'm.fk_estado')
                ->where('cf.pk_cliente_final', 'LIKE', "%{$search}%")
                ->orWhere('cf.nome_fantasia', 'LIKE',"%{$search}%")
                ->orWhere('e.nome', 'LIKE',"%{$search}%")
                ->orWhere('m.nome', 'LIKE',"%{$search}%")
                ->orWhere('cf.razao_social', 'LIKE',"%{$search}%")
                ->orWhere('cf.email', 'LIKE',"%{$search}%")
                ->orWhere('cf.telefone1', 'LIKE',"%{$search}%")
                ->orWhere('cf.telefone2', 'LIKE',"%{$search}%")
                ->orWhere('cf.cep', 'LIKE',"%{$search}%")
                ->orWhere('cf.bairro', 'LIKE',"%{$search}%")
                ->orWhere('cf.rua', 'LIKE',"%{$search}%")
                ->orWhere('cf.logradouro', 'LIKE',"%{$search}%")
                ->orWhere('cf.complemento', 'LIKE',"%{$search}%")
                ->where('cf.ativo', '=', true)
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $municipio = $obj->municipio()->first();

                if(empty($municipio))
                    continue;

                $estado = $municipio->estado()->first();

                $nestedData['pk_cliente_final'] = $obj->pk_cliente_final;
                $nestedData['estado']           = $estado->nome;
                $nestedData['municipio']        = $municipio->nome;
                $nestedData['nome_fantasia']    = $obj->nome_fantasia;
                $nestedData['razao_social']     = $obj->razao_social;
                $nestedData['email']            = $obj->email;
                $nestedData['telefone1']        = $obj->telefone1;
                $nestedData['telefone2']        = $obj->telefone2;
                $nestedData['cep']              = $obj->cep;
                $nestedData['bairro']           = $obj->bairro;
                $nestedData['rua']              = $obj->rua;
                $nestedData['logradouro']       = $obj->logradouro;
                $nestedData['complemento']      = $obj->complemento;
                $nestedData['ativo']            = $obj->ativo;
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

    public function store(ClienteFinalRequest $request)
    {
        $validate = $request->validated();

        $model = new ClienteFinal();
        $model->setMunicipioAttribute($validate['slt_municipio']);

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
        $model = ClienteFinal::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente Final não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    public function update(ClienteFinalRequest $request, $id)
    {
        $model = ClienteFinal::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente Final não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $validate = $request->validated();

        $model->setMunicipioAttribute($validate['slt_municipio']);

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
        $model = ClienteFinal::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente Final não existe'
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



    /**
     * Retorna as rotas que obtiveram maior quantidade em kilos de coleta
     * @param Request $request
     * @return JsonResponse
     */
    public function dashboardMaioresCompradores() {

        $data = ClienteFinal::from('cliente_final as cf')
            ->select(
                'cf.razao_social as labels',
                DB::raw('round(sum(f.peso)::numeric, 2) as values')
            )
            ->leftJoin('fardo as f', 'f.fk_cliente_final', '=', 'cf.pk_cliente_final')
            ->where('cf.ativo', '=', true)
            ->groupBy('cf.razao_social')
            ->orderBy('values', 'desc')
            ->limit(10)
            ->get();

        $labels = $data->pluck('labels');
        $values = $data->pluck('values');

        return response()->json([
            'success' => true,
            'data' => DashboardHelper::concatValues($labels, $values)
        ]);
    }


}
