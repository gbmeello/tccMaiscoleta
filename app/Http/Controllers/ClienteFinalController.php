<?php

namespace App\Http\Controllers;

use App\ClienteFinal;
use Illuminate\Http\Request;

class ClienteFinalController extends Controller
{
    private $viewName = 'clienteFinal';

    public function index()
    {
        return view($this->viewName.'.index');
    }

    public function create()
    {
        return view($this->viewName.'.cadastrar');
    }

    public function edit($id)
    {
        $obj = ClienteFinal::find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.atualizar', compact(['obj' => $obj]));
        }

        Session::flash('message', "Cliente Final não foi encontrado");
        return redirect($this->viewName.'/index')->send();
    }

    public function delete($id)
    {
        $tipoResiduo = ClienteFinal::find($id);

        if(!empty($tipoResiduo)) {
            return view($this->viewName.'.deletar', compact(['obj' => $tipoResiduo]));
        }

        Session::flash('message', "Cliente Final não foi encontrado");
        return redirect($this->viewName.'/index')->send();
    }
}
