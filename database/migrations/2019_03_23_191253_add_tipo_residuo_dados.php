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
                'nome'          => 'Resíduo Domiciliar',
                'descricao'     =>
                    'São os resíduos originados nas residências, especificamente urbanas. São os restos de alimentos como frutas, verduras,
                    grãos, etc., produtostipos de residuos deteriorados como garrafas, jornais, revistas, papel higiênico, fraldas descartáveis e 
                    muitos outros produtos. Muitas vezes, encontram-se também produtos poluentes e tóxicos.',
            ],
            [
                'nome'          => 'Resíduos de Limpeza Urbana',
                'descricao'     => 'Os originários da varrição, limpeza de logradouros e vias públicas e outros serviços de limpeza urbana',
            ],
            [
                'nome'          => 'Resíduos Sólidos Urbanos',
                'descricao'     =>
                    'São os resíduos originados nas residências, especificamente urbanas, além originários da varrição, 
                    limpeza de logradouros e vias públicas e outros serviços de limpeza urbana',
            ],
            [
                'nome'          => 'Resíduos de estabelecimentos comerciais e prestadores de serviços',
                'descricao'     => 'Resíduos gerados em supermercados, bares, restaurantes, escritórios, etc.',
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
