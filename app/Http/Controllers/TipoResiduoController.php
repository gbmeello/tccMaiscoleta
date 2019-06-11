<?php

namespace App\Http\Controllers;

use App\TipoResiduo;
use Illuminate\Support\Facades\Session;

class TipoResiduoController extends Controller
{
    const PERM_TIPO_RESIDUO_ADICIONAR = 'tipo_residuo_adicionar';
    const PERM_TIPO_RESIDUO_ATUALIZAR = 'tipo_residuo_atualizar';
    const PERM_TIPO_RESIDUO_LISTAR = 'tipo_residuo_listar';
    const PERM_TIPO_RESIDUO_REMOVER = 'tipo_residuo_remover';

    private $viewName = 'tipoResiduo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        return view($this->viewName.'.index');
    }

    public function create()
    {
        return view($this->viewName.'.cadastrar');
    }

    public function edit($id)
    {
        $obj = TipoResiduo::find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', ['obj' => $obj]);
        }

        Session::flash('message', "O Tipo de Resíduo não foi encontrado");
        return redirect($this->viewName.'/index')->send();
    }
}
