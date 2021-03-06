<?php

namespace App\Http\Controllers\Api\v1;

use App\Dashboard\DashboardHelper;
use App\Rota;
use App\PontoColeta;
use App\Helper\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PontoColetaRequest;

class PontoColetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $columns = [
            'pk_ponto_coleta',
            'nome',
            'latitude',
            'longitude',
            'ativo'
        ];

        $totalData = PontoColeta::where('ativo', '=', true)->count();

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
            $model = PontoColeta::offset($start)
                ->where('ativo', '=', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $model = PontoColeta::where('pk_ponto_coleta', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('latitude', 'LIKE',"%{$search}%")
                ->orWhere('longitude', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->where('ativo', '=', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = PontoColeta::where('pk_ponto_coleta', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('latitude', 'LIKE',"%{$search}%")
                ->orWhere('longitude', 'LIKE',"%{$search}%")
                ->orWhere('descricao', 'LIKE',"%{$search}%")
                ->where('ativo', '=', true)
                ->count();
        }

        $data = [];
        if(!empty($model))
        {
            foreach ($model as $obj)
            {
                $nestedData['pk_ponto_coleta']  = $obj->pk_ponto_coleta;
                $nestedData['nome']             = $obj->nome;
                $nestedData['latitude']         = $obj->latitude;
                $nestedData['longitude']        = $obj->longitude;
                $nestedData['descricao']        = $obj->descricao;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param PontoColetaRequest $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {

            $models = json_decode($request->input('json'));

            $models = collect($models);

            $idsRota = $models->pluck('rota')->unique()->values()->all();

            foreach($idsRota as $rota) {

                $pontosColeta = [];

                foreach($models as $model) {

                    if($rota === $model->rota) {

                        if(PontoColeta::where('nome', '=', $model->nome)->first()) {

                            return response()->json([
                                'success' => false,
                                'message' => ['O nome já existe']
                            ], ApiController::HTTP_STATUS_BAD_REQUEST);

                        }

                        $ids = PontoColeta::create([
                            'nome'      => $model->nome,
                            'latitude'  => $model->latitude,
                            'longitude' => $model->longitude,
                            'descricao' => $model->descricao
                        ]);

                        array_push($pontosColeta, $ids->pk_ponto_coleta);

                    }

                }

                $obj = Rota::where('ativo', true)->find($rota);
                $obj->pontosColeta()->attach($pontosColeta);
            }

            // $model = new PontoColeta();
            // $success = $model->fill($validate)->save();

            return response()->json([
                'success' => true,
                'message' => 'Cadastro realizado com sucesso'
            ]);
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao realizar o cadastro. Por favor, tente novamente'
            ], ApiController::HTTP_STATUS_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param PontoColetaRequest $id
     * @return Response
     */
    public function show($id)
    {
        $model = PontoColeta::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Rota não existe'
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
     * @param PontoColetaRequest $request
     * @param int $id
     * @return Response
     */
    public function update(PontoColetaRequest $request, $id)
    {
        $model = PontoColeta::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Ponto de Coleta não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $success = $model->fill($request->toArray())->save();

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
     * @return Response
     */
    public function destroy($id)
    {
        $model = PontoColeta::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Ponto de Coleta não existe'
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
