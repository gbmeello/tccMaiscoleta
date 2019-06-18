<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Veiculo;

class VeiculoController extends Controller
{
    const PERM_VEICULO_ADICIONAR    = 'veiculo_adicionar';
    const PERM_VEICULO_ATUALIZAR    = 'veiculo_atualizar';
    const PERM_VEICULO_LISTAR       = 'veiculo_listar';
    const PERM_VEICULO_REMOVER      = 'veiculo_remover';

    private $viewName = 'veiculo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        $obj = Veiculo::where('ativo', '=', true)->find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', ['obj' => $obj]);
        }

        Session::flash('message', "O Veículo não foi encontrado");

        return redirect()->back();
    }
}
