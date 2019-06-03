<?php

use Illuminate\Database\Seeder;

class RotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rota')->insert([
            [
                'nome' => 'Rota 1',
                'observacao' => 'Observação da rota 1'
            ], [
                'nome' => 'Rota 2',
                'observacao' => 'Observação da rota 2',
            ]
        ]);
    }
}
