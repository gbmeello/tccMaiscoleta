<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoResiduoPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            [
                'nome'          => 'TIPO_RESIDUO_CADASTRAR',
                'descricao'     => 'Cadastro do tipo de residuo',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'TIPO_RESIDUO_EDITAR',
                'descricao'     => 'Edição do tipo de residuo',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'TIPO_RESIDUO_LISTAR',
                'descricao'     => 'Listagem do tipo de residuo',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'TIPO_RESIDUO_EXCLUIR',
                'descricao'     => 'Exclusão do tipo de residuo',
                'grupo'         => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->whereIn('nome', [
            'TIPO_RESIDUO_CADASTRAR',
            'TIPO_RESIDUO_EDITAR',
            'TIPO_RESIDUO_LISTAR',
            'TIPO_RESIDUO_EXCLUIR'
        ])->delete();
    }
}
