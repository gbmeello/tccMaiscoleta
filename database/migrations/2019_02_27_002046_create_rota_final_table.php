<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRotaFinalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rota_final', function (Blueprint $table) {
            $table->integer('pk_rota')->comment('Chave primaria em uma relação de n para n, vinda da tabela Rota');
            $table->integer('pk_ponto_coleta')->comment('Chave primaria em uma relação de n para n, vinda da tabela Ponto_Coleta');
            $table->integer('fk_veiculo')->comment('Chave estrangeira vinda da tabela Veiuclo');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status do residuo: ativo(1), inativo(2) ou excluido(3)');

            $table->foreign('fk_veiculo')->references('pk_veiculo')->on('veiculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rota_final');
    }
}
