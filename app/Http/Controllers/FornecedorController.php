<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    private $viewName = 'fornecedor';

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
        $obj = Fornecedor::find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.atualizar', compact(['obj' => $obj]));
        }

        Session::flash('message', "Fornecedor não foi encontrado");
        return redirect($this->viewName.'/index')->send();
    }

    public function delete($id)
    {
        $tipoResiduo = Fornecedor::find($id);

        if(!empty($tipoResiduo)) {
            return view($this->viewName.'.deletar', compact(['obj' => $tipoResiduo]));
        }

        Session::flash('message', "Fornecedor não foi encontrado");
        return redirect($this->viewName.'/index')->send();
    }
}
