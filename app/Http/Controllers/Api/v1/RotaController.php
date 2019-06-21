<?php

namespace App\Http\Controllers\Api\v1;

use App\Dashboard\DashboardHelper;
use App\Fardo;
use App\Rota;
use App\Helper\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RotaRequest;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\DB;

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

        $totalData = Rota::where('ativo', '=', true)->count();

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
                $nestedData['pontosColeta'] = $obj->pontosColeta()->get();
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

        return response()->json(Helpers::replaceNullWithEmptyString($json_data));
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
        $model = Rota::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Rota não encontrada'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $model->pontosColeta = $model->pontosColeta()->get();

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    public function update(RotaRequest $request, $id)
    {
        $model = Rota::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Rota não encontrada'
            ]);
        }

        $validate = $request->validated();

        $success = $model->fill($validate->toArray());

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

    public function getGeoJsonPontosColetaByRota($id) {
        try {
            $geojson = [
                'success' => true,
                'data' => [
                    'type' => 'FeatureCollection',
                    'features' => []
                ]
            ];

            $rota = Rota::find($id);
            $pontosColeta = $rota->pontosColeta()->get();

            foreach($pontosColeta as $key => $value) {

                $marker = [
                    'type' => 'Feature',
                    'properties' => [
                        'title' => $value->nome,
                        'marker-color' => '#f00',
                        'marker-size' => 'small'
                    ],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $value->longitude,
                            $value->latitude
                        ]
                    ]
                ];

                array_push($geojson['data']['features'], $marker);

            }

            echo json_encode($geojson);
        }
        catch(\Exception $ex) {
            echo json_encode([
                'success' => false,
                'message' => 'Ocorreu um erro. Por favor, tente novamente.'
            ]);
        }
    }


    /**
     * Retorna as rotas que obtiveram maior quantidade em kilos de coleta
     * @param Request $request
     * @return JsonResponse
     */
    public function dashboardRotasMaisColetadas() {

        $data = Fardo::from('fardo as f')
            ->select(
                'r.nome as labels',
                DB::raw('round(sum(f.peso)::numeric, 2) as values')
            )
            ->leftJoin('triagem as t', 't.pk_triagem', '=', 'f.fk_triagem')
            ->leftJoin('coleta as c', 'c.pk_coleta', '=', 't.fk_coleta')
            ->join('rota_final as rf', 'rf.fk_rota', '=', 'c.fk_rota')
            ->leftJoin('rota as r', 'r.pk_rota', '=', 'rf.fk_rota')
            ->where('r.ativo', '=', true)
            ->groupBy('r.nome')
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
