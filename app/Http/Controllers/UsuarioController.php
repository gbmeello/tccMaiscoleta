<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Usuario;
use App\Roles;

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
        $perfis = Roles::where('ativo', '=', true)->get();

        return view($this->viewName.'.cadastrar', ['perfis' => $perfis]);
    }

    public function edit($id)
    {
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
}
