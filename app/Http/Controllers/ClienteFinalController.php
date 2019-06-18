<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Municipio;
use App\ClienteFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClienteFinalController extends Controller
{
    const PERM_CLIENTE_FINAL_ADICIONAR    = 'cliente_final_adicionar';
    const PERM_CLIENTE_FINAL_ATUALIZAR    = 'cliente_final_atualizar';
    const PERM_CLIENTE_FINAL_LISTAR       = 'cliente_final_listar';
    const PERM_CLIENTE_FINAL_REMOVER      = 'cliente_final_remover';

    private $viewName = 'clienteFinal';

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

        $estados = Estado::All();
        return view($this->viewName.'.cadastrar', ['estados' => $estados]);
    }

    public function edit($id)
    {
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }
        
        $estados = Estado::All();

        $obj = ClienteFinal::where('ativo', '=', true)->find($id);

        $estado     = $obj->municipio()->first()->estado()->first();
        $municipios = $estado->municipios()->get();

        if(!empty($obj)) {
            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'estados' => $estados,
                'municipios' => $municipios
            ]);
        }

        Session::flash('message', "Cliente Final não foi encontrado");

        return redirect()->back();
    }
}
