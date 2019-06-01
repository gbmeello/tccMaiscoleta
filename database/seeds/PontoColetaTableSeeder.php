<?php

use Illuminate\Database\Seeder;

class PontoColetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ponto_coleta')->insert([
            [
                'nome' => 'Ponto Coleta 1',
                'latitude' => -22.968463988546702,
                'longitude' => -42.022770529116514,
            ], [
                'nome' => 'Ponto Coleta 2',
                'latitude' => -22.968345449470817,
                'longitude' => -42.018521910037464,
            ], [
                'nome' => 'Ponto Coleta 3',
                'latitude' => -22.96672540510383,
                'longitude' => -42.02186930688967,
            ], [
                'nome' => 'Ponto Coleta 4',
                'latitude' => -22.96802934477863,
                'longitude' => -42.024057989444856,
            ]
        ]);
    }
}
