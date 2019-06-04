<?php

namespace App\Http\Controllers;

use App\Rota;
use App\Veiculo;
use App\Fornecedor;

class ColetaController extends Controller
{
    private $viewName = 'coleta';

    public function index()
    {
        return view($this->viewName.'.index');
    }

    public function create()
    {
        $rotas = Rota::where('ativo', true)->get();
        $veiculos = Veiculo::where('ativo', true)->get();
        $fornecedores = Fornecedor::where('ativo', true)->get();

        return view($this->viewName.'.cadastrar', [
            'rotas' => $rotas,
            'veiculos' => $veiculos,
            'fornecedores' => $fornecedores,
        ]);
    }

    public function edit($id)
    {

        $obj = Fornecedor::find($id);

        if(!empty($obj)) {

            $rotas = Rota::where('ativo', true);
            $veiculos = Veiculo::where('ativo', true);
            $fornecedores = Fornecedor::where('ativo', true);

            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'rotas' => $rotas,
                'veiculos' => $veiculos,
                'fornecedores' => $fornecedores,
            ]);
        }

        Session::flash('message', "Fornecedor não foi encontrado");
        return redirect($this->viewName.'/index')->send();
    }

    // public function delete($id)
    // {
    //     $tipoResiduo = Fornecedor::find($id);

    //     if(!empty($tipoResiduo)) {
    //         return view($this->viewName.'.deletar', compact(['obj' => $tipoResiduo]));
    //     }

    //     Session::flash('message', "Fornecedor não foi encontrado");
    //     return redirect($this->viewName.'/index')->send();
    // }
}
