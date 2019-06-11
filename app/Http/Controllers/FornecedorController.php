<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FornecedorController extends Controller
{
    private $viewName = 'fornecedor';

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
        $estados = Estado::All();
        return view($this->viewName.'.cadastrar', ['estados' => $estados]);
    }

    public function edit($id)
    {
        $estados = Estado::All();

        $obj = Fornecedor::find($id);

        $estado     = $obj->municipio()->first()->estado()->first();
        $municipios = $estado->municipios()->get();

        if(!empty($obj)) {
            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'estados' => $estados,
                'municipios' => $municipios
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
