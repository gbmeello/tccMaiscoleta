<?php

namespace App\Http\Controllers;

use App\Fardo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FardoController extends Controller
{
    const PERM_FARDO_ADICIONAR    = 'fardo_adicionar';
    const PERM_FARDO_ATUALIZAR    = 'fardo_atualizar';
    const PERM_FARDO_LISTAR       = 'fardo_listar';
    const PERM_FARDO_REMOVER      = 'fardo_remover';

    private $viewName = 'fardo';

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

        $unidadesMedida = Fardo::UNIDADES_MEDIDA;
        $status = Fardo::STATUS;
        return view($this->viewName.'.cadastrar', [
            'unidadesMedida' => $unidadesMedida,
            'status' => $status
        ]);
    }

    public function edit($id)
    {
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }
        
        $obj = Fardo::where('ativo', '=', true)->find($id);

        if(!empty($obj)) {

            $unidadesMedida = Fardo::UNIDADES_MEDIDA;
            $status = Fardo::STATUS;

            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'status' => $status,
                'unidadesMedida' => $unidadesMedida
            ]);
        }

        Session::flash('message', "Fardo não foi encontrado");

        return redirect()->back();
    }
}
