<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    private $viewName = 'usuario';

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
        
        $perfis = Roles::where('ativo', '=', true)->get();

        return view($this->viewName.'.cadastrar', ['perfis' => $perfis]);
    }

    public function edit($id)
    {
        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }

        $obj = Usuario::where('ativo', '=', true)->find($id);

        $perfis = Roles::where('ativo', '=', true)->get();

        if(!empty($obj)) {
            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'perfis' => $perfis
            ]);
        }

        Session::flash('message', "O Usuário não foi encontrado");

        return redirect()->back();
    }

    public function perfil() {

        if(! Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
            Session::flash('message', "Você não possui permissão para essa ação");
            return redirect()->back();
        }

        return view($this->viewName.'.perfil');
    }
}
