<?php

namespace App\Http\Controllers\Api\v1;

use App\Usuario;
use App\Helper\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $columns = [
            'pk_usuario',
            'nome',
            'email',
            'perfil',
            'ativo'
        ];

        $totalData      = Usuario::where('ativo', '=', true)->count();
        $totalFiltered  = $totalData;
        $columnOrder    = ($request->input('order.0.column') == $columns[0] ? $request->input('order.0.column') : 0);

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$columnOrder];
        $dir    = (empty($request->input('order.0.dir')) ? 'asc' : $request->input('order.0.dir'));
        $models = null;

        if(empty($request->input('search.value'))) {

            $models = Usuario::from('usuario as u')
                ->leftJoin('roles as r', 'r.pk_role', '=', 'u.fk_role')
                ->select(
                    'u.pk_usuario',
                    'u.nome',
                    'u.email',
                    'u.ativo as u_ativo',
                    'r.nome as perfil'
                )
                ->offset($start)
                ->where('u.ativo', '=', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $search = $request->input('search.value');

            $models = Usuario::from('usuario as u')
                ->leftJoin('roles as r', 'r.pk_role', '=', 'u.fk_role')
                ->select(
                    'u.pk_usuario',
                    'u.nome',
                    'u.email',
                    'u.ativo as u_ativo',
                    'r.nome as perfil'
                )
                ->where('pk_usuario', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('perfil', 'LIKE',"%{$search}%")
                ->where('u.ativo', '=', true)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Usuario::from('usuario as u')
                ->leftJoin('roles as r', 'r.pk_role', '=', 'u.fk_role')
                ->select(
                    'u.pk_usuario',
                    'u.nome',
                    'u.email',
                    'u.ativo as u_ativo',
                    'r.nome as perfil'
                )
                ->where('pk_usuario', 'LIKE', "%{$search}%")
                ->orWhere('nome', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('perfil', 'LIKE',"%{$search}%")
                ->where('u.ativo', '=', true)
                ->count();
        }

        $data = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $nestedData['pk_usuario']   = $model->pk_usuario;
                $nestedData['nome']         = $model->nome;
                $nestedData['email']        = $model->email;
                $nestedData['perfil']       = $model->perfil;
                $nestedData['ativo']        = $model->u_ativo;
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
    public function store(UsuarioRequest $request)
    {
        $validate = $request->validated();

        $model = new Usuario();
        $model->setPerfilAttribute($validate['slt_perfil']);

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
        $model = Usuario::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não existe'
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
    public function update(UsuarioRequest $request, $id)
    {
        $model = Usuario::where('ativo', '=', true)->find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não existe'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        $validate = $request->validated();

        $model->setPerfilAttribute($validate['slt_perfil']);

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
        $model = Usuario::find($id);
        if(empty($model)) {
            return response()->json([
                'success' => false,
                'message' => 'O Usuário não existe'
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
