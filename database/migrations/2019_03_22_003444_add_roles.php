<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
            [
                'nome'          => 'Administrador',
                'descricao'     => 'Administrador geral do sistema',
                'grupo'         => 1,
            ],
            [
                'nome'          => 'Cadastrador',
                'descricao'     => 'Alimentador do sistema',
                'grupo'         => 2,
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
        DB::table('roles')->whereIn('nome', [
            'Administrador', 'Cadastrador'
        ])->delete();
    }
}
