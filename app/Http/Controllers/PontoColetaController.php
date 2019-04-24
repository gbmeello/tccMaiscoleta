<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PontoColetaController extends Controller
{
    public function index()
    {
        return view('pontoColeta.index');
    }

    public function create()
    {
        return view('pontoColeta.cadastrar');
    }

    public function edit($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('pontoColeta.atualizar', compact(['pontoColeta' => $tipoResiduo]));
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
