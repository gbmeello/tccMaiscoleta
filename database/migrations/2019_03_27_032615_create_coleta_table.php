<?php

use App\Extendz\CustomBlueprint;
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
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new CustomBlueprint($table, $callback);
        });

        //TODO terminar tabela coleta
        $schema->create('coleta', function (Blueprint $table) {
            $table->increments('pk_coleta')->comment('Chave primária e única da tabela Coleta');
            $table->unsignedInteger('fk_ponto_coleta')->comment('Chave estrangeira vinda da tabela Ponto_Coleta');
            $table->unsignedInteger('fk_veiculo')->comment('Chave estrangeira vinda da tabela Veiculo');
            $table->unsignedInteger('fk_fornecedor')->comment('Chave estrangeira vinda da tabela Fornecedor');
            $table->timestamp('data_coleta')->comment('Data da coleta');
            $table->boolean('has_coleta')->comment('Se teve coleta ou não naquele dia');
            $table->string('observacao', 1000)->nullable()->comment('Observação relacionada a coleta');
            $table->customTimestamps();
            $table->tinyInteger('status')->default(1)->comment('Status que se encontra atualmente a coleta: ativo(1), inativo(2) ou excluido(3)');

            $table->foreign('fk_ponto_coleta')->references('pk_ponto_coleta')->on('ponto_coleta')->onDelete('cascade');
            $table->foreign('fk_veiculo')->references('pk_veiculo')->on('veiculo')->onDelete('cascade');
            $table->foreign('fk_fornecedor')->references('pk_fornecedor')->on('fornecedor')->onDelete('cascade');
        });
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