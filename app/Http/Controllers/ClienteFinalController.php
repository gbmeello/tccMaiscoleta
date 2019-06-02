<?php

namespace App\Http\Controllers;

use App\ClienteFinal;
use Illuminate\Http\Request;
use App\Estado;

class ClienteFinalController extends Controller
{
    const CLIENTE_FINNAL_CADASTRAR  = 'CLIENTE_FINNAL_CADASTRAR';
    const CLIENTE_FINNAL_EDITAR     = 'CLIENTE_FINNAL_EDITAR';
    const CLIENTE_FINNAL_LISTAR     = 'CLIENTE_FINNAL_LISTAR';
    const CLIENTE_FINNAL_DELETAR    = 'CLIENTE_FINNAL_DELETAR';

    private $viewName = 'clienteFinal';

    public function index()
    {
        return view($this->viewName.'.index');
    }

    public function create()
    {
        $estados = Estado::All();

        return view($this->viewName.'.cadastrar', [
            'estados' => $estados
        ]);
    }

    public function edit($id)
    {
        $estados = Estado::All();

        $obj = ClienteFinal::find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'estados' => $estados
            ]);
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
