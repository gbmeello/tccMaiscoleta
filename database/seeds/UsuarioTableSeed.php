<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('roles')->where('nome', 'Administrador')->first();

        DB::table('usuario')->insert([
            [
                'fk_role'   => $role->pk_role,
                'nome'      => 'Administrador',
                'email'     => 'admin@email.com',
                'senha'     => Hash::make('admin123')
            ],
        ]);
    }
}
