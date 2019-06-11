<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Rota;

class RotaController extends Controller
{
    private $viewName = 'rota';

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
        return view($this->viewName.'.cadastrar');
    }

    public function edit($id)
    {
        $obj = Rota::find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', ['obj' => $obj]);
        }

        Session::flash('message', "A Rota não foi encontrada");
        return redirect($this->viewName.'/index')->send();
    }
}
