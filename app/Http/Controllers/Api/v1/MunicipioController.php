<?php

namespace App\Http\Controllers\Api\v1;

use App\Municipio;
use App\Http\Controllers\Controller;
use App\Estado;

class MunicipioController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Municipio::All();
        return response()->json([
            'success' => true,
            'data' => $list
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = Municipio::find($id);

        if(empty($estado)) {
            return response()->json([
                'success' => false,
                'message' => 'O município não foi encontrado'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $obj
        ]);
    }

    
    public function getByEstado($id)
    {
        $estado = Estado::find($id);

        if(empty($estado)) {
            return response()->json([
                'success' => false,
                'message' => 'O estado não foi encontrado'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }
        
        $municipios = $estado->municipios()->get();

        return response()->json([
            'success' => true,
            'data' => $municipios
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
