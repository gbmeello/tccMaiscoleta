<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Municipio;
use App\ClienteFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClienteFinalController extends Controller
{
    const CLIENTE_FINAL_CADASTRAR  = 'CLIENTE_FINAL_CADASTRAR';
    const CLIENTE_FINAL_EDITAR     = 'CLIENTE_FINAL_EDITAR';
    const CLIENTE_FINAL_LISTAR     = 'CLIENTE_FINAL_LISTAR';
    const CLIENTE_FINAL_DELETAR    = 'CLIENTE_FINAL_DELETAR';

    private $viewName = 'clienteFinal';

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

        $obj = ClienteFinal::find($id);

        $estado     = $obj->municipio()->first()->estado()->first();
        $municipios = $estado->municipios()->get();

        if(!empty($obj)) {
            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'estados' => $estados,
                'municipios' => $municipios
            ]);
        }

        Session::flash('message', "Cliente Final não foi encontrado");

        return redirect()->back();
    }
}
