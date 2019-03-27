<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*$schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new CustomBlueprint($table, $callback);
        });

        //TODO terminar tabela coleta
        $schema->create('coleta', function (Blueprint $table) {
            $table->increments('pk_ponto_coleta')->comment('Chave primária e única da tabela Ponto_Coleta');
            $table->unsignedInteger('fk_rota')->comment('Chave estrangeira vinda da tabela Ponto_Coleta');
            $table->unsignedInteger('fk_veiculo')->comment('Chave estrangeira vinda da tabela Veiculo');
            $table->unsignedInteger('fk_fornecedor')->comment('Chave kl');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status que se encontra atualmente a coleta: ativo(1), inativo(2) ou excluido(3)');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coleta');
    }
}
