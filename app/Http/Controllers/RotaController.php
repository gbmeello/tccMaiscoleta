<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Rota;

class RotaController extends Controller
{
    public function index()
    {
        return view('rota.index');
    }

    public function create()
    {
        return view('/rota.cadastrar');
    }

    public function edit($id)
    {
        $tipoResiduo = Rota::find($id);

        if(!empty($tipoResiduo)) {
            return view('rota.editar', compact(['tipoResiduo' => $tipoResiduo]));
        }

        Session::flash('message', "Tipo de Resíduo não foi encontrado");
        return redirect('rota/index')->send();
    }

    public function delete($id)
    {
        $tipoResiduo = Rota::find($id);

        if(!empty($tipoResiduo)) {
            return view('rota.deletar', compact(['tipoResiduo' => $tipoResiduo]));
        }

        Session::flash('message', "Tipo de Resíduo não foi encontrado");
        return redirect('rota/index')->send();
    }
}
