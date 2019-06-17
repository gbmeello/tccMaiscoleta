<?php

namespace App\Http\Controllers;

use App\Triagem;
use Illuminate\Support\Facades\Session;

class TriagemController extends Controller
{
    private $viewName = 'triagem';

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
        $obj = Triagem::find($id);

        if(!empty($obj)) {
            return view($this->viewName.'.editar', ['obj' => $obj]);
        }

        Session::flash('message', "A Triagem não foi encontrada");

        return redirect()->back();
    }

}
