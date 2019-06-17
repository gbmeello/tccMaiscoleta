<?php

namespace App\Http\Controllers;

use App\Rota;
use Illuminate\Support\Facades\Session;
use App\PontoColeta;

class PontoColetaController extends Controller
{
    private $viewName = 'pontoColeta';

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
        $rotas = Rota::where('ativo', '=', true)->get();

        return view($this->viewName.'.cadastrar', ['rotas' => $rotas]);
    }

    public function edit($id)
    {
        $obj = PontoColeta::find($id);

        if(!empty($tipoResiduo)) {
            return view($this->viewName.'.editar', compact(['obj' => $obj]));
        }

        Session::flash('message', 'O Ponto de Coleta não foi encontrado');

        return redirect()->back();
    }
}
