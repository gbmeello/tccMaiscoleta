<?php

namespace App\Http\Controllers;

class VeiculoController extends Controller
{
    const PERM_VEICULO_ADICIONAR    = 'veiculo_adicionar';
    const PERM_VEICULO_ATUALIZAR    = 'veiculo_atualizar';
    const PERM_VEICULO_LISTAR       = 'veiculo_listar';
    const PERM_VEICULO_REMOVER      = 'veiculo_remover';

    public function index()
    {
        return view('veiculo.index');
    }

    public function create()
    {
        return view('veiculo.cadastrar');
    }

    public function edit($id)
    {
        $obj = Veiculo::find($id);

        if(!empty($obj)) {
            return view('veiculo.editar', compact(['obj' => $obj]));
        }

        Session::flash('message', "Veículo não foi encontrado");
        return redirect('veiculo/index')->send();
    }

    public function delete($id)
    {
        $obj = Veiculo::find($id);

        if(!empty($obj)) {
            return view('veiculo.deletar', compact(['obj' => $obj]));
        }

        Session::flash('message', "Veiculo não foi encontrado");
        return redirect('veiculo/index')->send();
    }
}
