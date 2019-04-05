<?php

namespace App\Http\Controllers;

use App\TipoResiduo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TipoResiduoController extends Controller
{
    const PERM_TIPO_RESIDUO_ADICIONAR = 'tipo_residuo_adicionar';
    const PERM_TIPO_RESIDUO_ATUALIZAR = 'tipo_residuo_atualizar';
    const PERM_TIPO_RESIDUO_LISTAR = 'tipo_residuo_listar';
    const PERM_TIPO_RESIDUO_REMOVER = 'tipo_residuo_remover';

    public function index()
    {
        return view('tipoResiduo.index');
    }

    public function create()
    {
        return view('/tipoResiduo.cadastrar');
    }

    public function edit($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('tipoResiduo.atualizar', compact(['tipoResiduo' => $tipoResiduo]));
        }

        Session::flash('message', "Tipo de Resíduo não foi encontrado");
        return redirect('tipoResiduo/index')->send();
    }

    public function delete($id)
    {
        $tipoResiduo = TipoResiduo::find($id);

        if(!empty($tipoResiduo)) {
            return view('tipoResiduo.deletar', compact(['tipoResiduo' => $tipoResiduo]));
        }

        Session::flash('message', "Tipo de Resíduo não foi encontrado");
        return redirect('tipoResiduo/index')->send();
    }
}
