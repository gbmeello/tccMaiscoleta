<?php

namespace App\Http\Controllers;

use App\Triagem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TriagemController extends Controller
{
    const PERM_TRIAGEM_ADICIONAR    = 'triagem_adicionar';
    const PERM_TRIAGEM_ATUALIZAR    = 'triagem_atualizar';
    const PERM_TRIAGEM_LISTAR       = 'triagem_listar';
    const PERM_TRIAGEM_REMOVER      = 'triagem_remover';

    private $viewName = 'triagem';

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
        
        return view($this->viewName.'.cadastrar');
    }

    public function edit($id)
    {
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }

        $obj = Triagem::where('ativo', '=', true)->find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', ['obj' => $obj]);
        }

        Session::flash('message', "A Triagem não foi encontrada");

        return redirect()->back();
    }

}
