<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoResiduoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_residuo', function (Blueprint $table) {
            $table->increments('pk_tipo_residuo')->comment('Chave primária e única da tabela Tipo_Residuo');
            $table->string('nome', 50)->comment('Nome do tipo de resíduo');
            $table->string('descricao', 300)->comment('Descrição do tipo de resíduo');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status que se encontra atualmente o tipo de resíduo: ativo(1), inativo(2) ou excluido(3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_residuo');
    }
}