<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResiduoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residuo', function (Blueprint $table) {
            $table->increments('pk_residuo')->comment('Chave primária e única da tabela Residuo');
            $table->integer('fk_tipo_residuo')->comment('Chave estrangeira vinda da tabela Tipo_Residuo');
            $table->string('lote')->comment('Lote do residuo');
            $table->string('observacao')->comment('Observação do residuo');
            $table->timestamp('data_coleta')->comment('Data de coleta do lote do resíduo');
            $table->timestamp('data_envio')->comment('Data de envio do lote do resíduo');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status do residuo: ativo(1), inativo(2) ou excluido(3)');

            $table->foreign('fk_tipo_residuo')->references('pk_tipo_residuo')->on('tipo_residuo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residuo');
    }
}
