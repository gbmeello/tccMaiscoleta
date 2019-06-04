<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{

    public function index()
    {
        return view('tipoResiduo.index');
    }

    public function create()
    {
        return view('/tipoResiduo.cadastrar');
    }

    public function edit($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('tipoResiduo.editar', compact(['tipoResiduo' => $tipoResiduo]));
        }

        Session::flash('message', "Tipo de Resíduo não foi encontrado");
        return redirect('tipoResiduo/index')->send();
    }

    public function delete($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('tipoResiduo.deletar', compact(['tipoResiduo' => $tipoResiduo]));
        }

        Session::flash('message', "Tipo de Resíduo não foi encontrado");
        return redirect('tipoResiduo/index')->send();
    }
}
