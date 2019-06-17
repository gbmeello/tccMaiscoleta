<?php

namespace App\Http\Controllers;

use App\Fardo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FardoController extends Controller
{
    private $viewName = 'fardo';

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
        $unidadesMedida = Fardo::UNIDADES_MEDIDA;
        $status = Fardo::STATUS;
        return view($this->viewName.'.cadastrar', [
            'unidadesMedida' => $unidadesMedida,
            'status' => $status
        ]);
    }

    public function edit($id)
    {
        $obj = Fardo::find($id);

        if(!empty($obj)) {

            $unidadesMedida = Fardo::UNIDADES_MEDIDA;
            $status = Fardo::STATUS;

            return view($this->viewName.'.editar', [
                'obj' => $obj,
                'status' => $status,
                'unidadesMedida' => $unidadesMedida
            ]);
        }

        Session::flash('message', "Fardo não foi encontrado");

        return redirect()->back();
    }
}
