<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarioAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = DB::table('roles')->where('nome', 'Administrador')->first();

        DB::table('usuario')->insert([
            [
                'fk_role'   => $role->pk_role,
                'nome'      => 'Administrador',
                'email'     => 'admin@email.com',
                'senha'     => bcrypt('admin123')
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
        DB::table('usuario')->whereIn('email', [
            'admin@email.com',
        ])->delete();
    }
}
