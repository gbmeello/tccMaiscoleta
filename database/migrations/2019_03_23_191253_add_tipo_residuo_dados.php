<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//TODO referencia -> http://www.planalto.gov.br/ccivil_03/_ato2007-2010/2010/lei/l12305.htm

class AddTipoResiduoDados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tipo_residuo')->insert([
            [
                'nome'          => 'Resíduos de Papel',
                'descricao'     =>
                    'São Resíduos de jornal, papel branco comun, papel pardo, papelão, cartolina, envelopes, papel de cartão, revistas, folhas de cardeno,
                     entre outros, não inclui papel auto-adesivo, carbono, celofane, de fax, fotográfico, termoabrasivo, 
                     ou plastificados, guardanapos, bitucas de cigarro',
            ],
            [
                'nome'          => 'Resíduos Plástico',
                'descricao'     =>
                    'São Resíduos de garrafa PET, embalagens de produtos de beleza e de limpeza, sacos plásticos, potes de margarina, copos de mate entre outros,
                    não inclui, copos descartáveis, fraldas, espumas, isopor, canos de PVC, fita cassete, DVD e CD',
            ],
            [
                'nome'          => 'Resíduos de Metal',
                'descricao'     =>
                    'São Resíduos de latas de alumínio, objetos de ferro, fios e cabos, embalagens de desodorante, entre outros, não inclui pihas e baterias, clipe,
                     grampo, prego, esponjas de aço, lata de tinta.',
            ],
            [
                'nome'          => 'Resíduos de Vidro',
                'descricao'     => 'Resíduos de garrafas, copos e recipientes em geral, não inclui espelho, cerâmica, tubo de tv, lâmpadas fluorescentes, remédios.',
            ],
            [
                'nome'          => 'Resíduos de serviços de saúde',
                'descricao'     =>
                    'Gerados nos serviços de saúde, conforme definido em regulamento ou em normas estabelecidas pelos 
                    órgãos do Sisnama e do SNVS: algodão, seringas, agulhas, restos de remédios, luvas, curativos, sangue 
                    coagulado, órgãos e tecidos removidos, meios de cultura e animais utilizados em testes, resina sintética, 
                    filmes fotográficos de raios X, etc.',
            ],
            [
                'nome'          => 'Resíduos da construção civil',
                'descricao'     =>
                    'Gerados nas construções, reformas, reparos e demolições de obras de construção civil, 
                    incluídos os resultantes da preparação e escavação de terrenos para obras civis.',
            ],
            [
                'nome'          => 'Resíduos agrossilvopastoris',
                'descricao'     =>
                    'Gerados nas atividades agropecuárias e silviculturais, incluídos os relacionados a 
                    insumos utilizados nessas atividades.',
            ],
            [
                'nome'          => 'Resíduos de serviços de transportes',
                'descricao'     => 'Originários de portos, aeroportos, terminais alfandegários, rodoviários e ferroviários e passagens de fronteira.',
            ],
            [
                'nome'          => 'Resíduos de mineração',
                'descricao'     => 'Gerados na atividade de pesquisa, extração ou beneficiamento de minérios.',
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
        DB::table('tipo_residuo')->whereIn('nome', [
            'Resíduo Domiciliar',
            'Resíduos de Limpeza Urbana',
            'Resíduos Sólidos Urbanos',
            'Resíduos de estabelecimentos comerciais e prestadores de serviços',
            'Resíduos de serviços de saúde',
            'Resíduos da construção civil',
            'Resíduos agrossilvopastoris',
            'Resíduos de serviços de transportes',
            'Resíduos de mineração'
        ])->delete();
    }
}
