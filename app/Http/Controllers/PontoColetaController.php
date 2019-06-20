<?php

namespace App\Http\Controllers;

use App\Rota;
use App\PontoColeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PontoColetaController extends Controller
{
    const PERM_PONTO_COLETA_ADICIONAR    = 'ponto_coleta_adicionar';
    const PERM_PONTO_COLETA_ATUALIZAR    = 'ponto_coleta_atualizar';
    const PERM_PONTO_COLETA_LISTAR       = 'ponto_coleta_listar';
    const PERM_PONTO_COLETA_REMOVER      = 'ponto_coleta_remover';

    private $viewName = 'pontoColeta';

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
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }
        
        $rotas = Rota::where('ativo', '=', true)->get();

        return view($this->viewName.'.cadastrar', ['rotas' => $rotas]);
    }

    public function edit($id)
    {
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }

        $rotas = Rota::where('ativo', '=', true)->get();

        $obj = PontoColeta::where('ativo', '=', true)->find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'rotas' => $rotas
            ]);
        }

        Session::flash('message', 'O Ponto de Coleta não foi encontrado');

        return redirect()->back();
    }
}
