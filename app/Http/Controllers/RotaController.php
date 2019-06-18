<?php

namespace App\Http\Controllers;

use App\Rota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RotaController extends Controller
{
    const PERM_ROTA_ADICIONAR    = 'rota_adicionar';
    const PERM_ROTA_ATUALIZAR    = 'rota_atualizar';
    const PERM_ROTA_LISTAR       = 'rota_listar';
    const PERM_ROTA_REMOVER      = 'rota_remover';

    private $viewName = 'rota';

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
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }

        return view($this->viewName.'.index');
    }

    public function create()
    {
        return view($this->viewName.'.cadastrar');
    }

    public function edit($id)
    {
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }
        
        $obj = Rota::where('ativo', '=', true)->find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', ['obj' => $obj]);
        }

        Session::flash('message', "A Rota não foi encontrada");

        return redirect()->back();
    }
}
