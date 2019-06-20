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
                'nome'          => 'tipo_residuo_adicionar',
                'descricao'     => 'Adição do tipo de residuo',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'tipo_residuo_atualizar',
                'descricao'     => 'Atualização do tipo de residuo',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'tipo_residuo_listar',
                'descricao'     => 'Listagem do tipo de residuo',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'tipo_residuo_remover',
                'descricao'     => 'Remoção do tipo de residuo',
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
            'tipo_residuo_adicionar',
            'tipo_residuo_atualizar',
            'tipo_residuo_listar',
            'tipo_residuo_remover'
        ])->delete();
    }
}
