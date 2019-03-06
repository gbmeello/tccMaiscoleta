<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculo', function (Blueprint $table) {
            $table->increments('pk_veiculo')->comment('Chave primária e unica da tabela Veiculo');
            $table->string('modelo', 100)->comment('Modelo do veículo');
            $table->string('observacao', 300)->comment('Observação relacionada ao veículo');
            $table->string('placa', 10)->comment('Placa do veículo');
            $table->string('tipo', 50)->comment('Tipo do veículo');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status do veículo: ativo(1), inativo(2) ou excluido(3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculo');
    }
}
