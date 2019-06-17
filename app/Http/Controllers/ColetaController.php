<?php

namespace App\Http\Controllers;

use App\Rota;
use App\Coleta;
use App\Veiculo;
use Carbon\Carbon;
use App\Fornecedor;
use Illuminate\Support\Facades\Session;

class ColetaController extends Controller
{
    private $viewName = 'coleta';

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
        $obj = Coleta::find($id);

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

        Session::flash('message', "Coleta não foi encontrada");

        return redirect()->back();
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
