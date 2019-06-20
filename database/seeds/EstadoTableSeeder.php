<?php

use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('estado')->insert(array (
            0 =>
            array (
                'pk_estado' => '1',
                'nome' => 'Acre',
                'sigla' => 'AC',
                'cod_ibge' => '12',
                'slug' => 'acre',
                'populacao' => '816687',
            ),
            1 =>
            array (
                'pk_estado' => '2',
                'nome' => 'Alagoas',
                'sigla' => 'AL',
                'cod_ibge' => '27',
                'slug' => 'alagoas',
                'populacao' => '3358963',
            ),
            2 =>
            array (
                'pk_estado' => '3',
                'nome' => 'Amazonas',
                'sigla' => 'AM',
                'cod_ibge' => '13',
                'slug' => 'amazonas',
                'populacao' => '4001667',
            ),
            3 =>
            array (
                'pk_estado' => '4',
                'nome' => 'Amapá',
                'sigla' => 'AP',
                'cod_ibge' => '16',
                'slug' => 'amapa',
                'populacao' => '782295',
            ),
            4 =>
            array (
                'pk_estado' => '5',
                'nome' => 'Bahia',
                'sigla' => 'BA',
                'cod_ibge' => '29',
                'slug' => 'bahia',
                'populacao' => '15276566',
            ),
            5 =>
            array (
                'pk_estado' => '6',
                'nome' => 'Ceará',
                'sigla' => 'CE',
                'cod_ibge' => '23',
                'slug' => 'ceara',
                'populacao' => '8963663',
            ),
            6 =>
            array (
                'pk_estado' => '7',
                'nome' => 'Distrito Federal',
                'sigla' => 'DF',
                'cod_ibge' => '53',
                'slug' => 'distrito-federal',
                'populacao' => '2977216',
            ),
            7 =>
            array (
                'pk_estado' => '8',
                'nome' => 'Espírito Santo',
                'sigla' => 'ES',
                'cod_ibge' => '32',
                'slug' => 'espirito-santo',
                'populacao' => '3973697',
            ),
            8 =>
            array (
                'pk_estado' => '9',
                'nome' => 'Goiás',
                'sigla' => 'GO',
                'cod_ibge' => '52',
                'slug' => 'goias',
                'populacao' => '6695855',
            ),
            9 =>
            array (
                'pk_estado' => '10',
                'nome' => 'Maranhão',
                'sigla' => 'MA',
                'cod_ibge' => '21',
                'slug' => 'maranhao',
                'populacao' => '6954036',
            ),
            10 =>
            array (
                'pk_estado' => '11',
                'nome' => 'Minas Gerais',
                'sigla' => 'MG',
                'cod_ibge' => '31',
                'slug' => 'minas-gerais',
                'populacao' => '20997560',
            ),
            11 =>
            array (
                'pk_estado' => '12',
                'nome' => 'Mato Grosso do Sul',
                'sigla' => 'MS',
                'cod_ibge' => '50',
                'slug' => 'mato-grosso-do-sul',
                'populacao' => '2682386',
            ),
            12 =>
            array (
                'pk_estado' => '13',
                'nome' => 'Mato Grosso',
                'sigla' => 'MT',
                'cod_ibge' => '51',
                'slug' => 'mato-grosso',
                'populacao' => '3305531',
            ),
            13 =>
            array (
                'pk_estado' => '14',
                'nome' => 'Pará',
                'sigla' => 'PA',
                'cod_ibge' => '15',
                'slug' => 'para',
                'populacao' => '8272724',
            ),
            14 =>
            array (
                'pk_estado' => '15',
                'nome' => 'Paraiba',
                'sigla' => 'PB',
                'cod_ibge' => '25',
                'slug' => 'paraiba',
                'populacao' => '3999415',
            ),
            15 =>
            array (
                'pk_estado' => '16',
                'nome' => 'Pernambuco',
                'sigla' => 'PE',
                'cod_ibge' => '26',
                'slug' => 'pernambuco',
                'populacao' => '9410336',
            ),
            16 =>
            array (
                'pk_estado' => '17',
                'nome' => 'Piauí',
                'sigla' => 'PI',
                'cod_ibge' => '22',
                'slug' => 'piaui',
                'populacao' => '3212180',
            ),
            17 =>
            array (
                'pk_estado' => '18',
                'nome' => 'Paraná',
                'sigla' => 'PR',
                'cod_ibge' => '41',
                'slug' => 'parana',
                'populacao' => '11242720',
            ),
            18 =>
            array (
                'pk_estado' => '19',
                'nome' => 'Rio de Janeiro',
                'sigla' => 'RJ',
                'cod_ibge' => '33',
                'slug' => 'rio-de-janeiro',
                'populacao' => '16635996',
            ),
            19 =>
            array (
                'pk_estado' => '20',
                'nome' => 'Rio Grande do Norte',
                'sigla' => 'RN',
                'cod_ibge' => '24',
                'slug' => 'rio-grande-do-norte',
                'populacao' => '3474998',
            ),
            20 =>
            array (
                'pk_estado' => '21',
                'nome' => 'Rondônia',
                'sigla' => 'RO',
                'cod_ibge' => '11',
                'slug' => 'rondonia',
                'populacao' => '1787279',
            ),
            21 =>
            array (
                'pk_estado' => '22',
                'nome' => 'Roraima',
                'sigla' => 'RR',
                'cod_ibge' => '14',
                'slug' => 'roraima',
                'populacao' => '514229',
            ),
            22 =>
            array (
                'pk_estado' => '23',
                'nome' => 'Rio Grande do Sul',
                'sigla' => 'RS',
                'cod_ibge' => '43',
                'slug' => 'rio-grande-do-sul',
                'populacao' => '11286500',
            ),
            23 =>
            array (
                'pk_estado' => '24',
                'nome' => 'Santa Catarina',
                'sigla' => 'SC',
                'cod_ibge' => '42',
                'slug' => 'santa-catarina',
                'populacao' => '6910553',
            ),
            24 =>
            array (
                'pk_estado' => '25',
                'nome' => 'Sergipe',
                'sigla' => 'SE',
                'cod_ibge' => '28',
                'slug' => 'sergipe',
                'populacao' => '2265779',
            ),
            25 =>
            array (
                'pk_estado' => '26',
                'nome' => 'São Paulo',
                'sigla' => 'SP',
                'cod_ibge' => '35',
                'slug' => 'sao-paulo',
                'populacao' => '44749699',
            ),
            26 =>
            array (
                'pk_estado' => '27',
                'nome' => 'Tocantins',
                'sigla' => 'TO',
                'cod_ibge' => '17',
                'slug' => 'tocantins',
                'populacao' => '1532902',
            ),
        ));
    }
}
