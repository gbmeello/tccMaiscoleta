<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rota;
use Illuminate\Support\Facades\Session;

class PontoColetaController extends Controller
{
    public function index()
    {
        return view('pontoColeta.index');
    }

    public function create()
    {
        $rotas = Rota::where('ativo', '=', true)->get();

        return view('pontoColeta.cadastrar', ['rotas' => $rotas]);
    }

    public function edit($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('pontoColeta.editar', compact(['pontoColeta' => $tipoResiduo]));
        }

        Session::flash('message', "pontoColeta não foi encontrado");
        return redirect('pontoColeta/index')->send();
    }

    public function delete($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('pontoColeta.deletar', compact(['pontoColeta' => $tipoResiduo]));
        }

        Session::flash('message', "pontoColeta não foi encontrado");
        return redirect('pontoColeta/index')->send();
    }
}
