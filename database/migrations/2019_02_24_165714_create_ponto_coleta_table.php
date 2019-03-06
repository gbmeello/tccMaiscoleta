<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePontoColetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponto_coleta', function (Blueprint $table) {
            $table->increments('pk_ponto_coleta')->comment('Chave primária e única da tabela Ponto_Coleta');
            $table->string('nome', 100)->comment('Nome do ponto de coleta');
            $table->point('coordenada')->comment('Coordenada do ponto de coleta');
            $table->string('descricao', 300)->comment('Descrição do ponto de coleta');
            $table->customTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ponto_coleta');
    }
}
