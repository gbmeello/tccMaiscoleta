<?php

namespace App\Http\Controllers;

use App\TipoResiduo;
use Illuminate\Http\Request;

class TipoResiduoController extends Controller
{
    public function index()
    {
        $tasks = TipoResiduo::all();

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $tipoResiduo = TipoResiduo::create($request->all());

        return response()->json([
            'message' => 'Great success! New TipoResiduo created',
            'TipoResiduo' => $tipoResiduo
        ]);
    }

    public function show(TipoResiduo $tipoResiduo)
    {
        return $tipoResiduo;
    }

    public function update(Request $request, TipoResiduo $tipoResiduo)
    {
        $request->validate([
            'title'       => 'nullable',
            'description' => 'nullable'
        ]);

        $tipoResiduo->update($request->all());

        return response()->json([
            'message' => 'Great success! TipoResiduo updated',
            'TipoResiduo' => $tipoResiduo
        ]);
    }

    public function delete(TipoResiduo $tipoResiduo)
    {
        $tipoResiduo->delete();

        return response()->json([
            'message' => 'Successfully deleted TipoResiduo!'
        ]);
    }
}
